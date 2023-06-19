<?php

namespace App\Controller;

use App\Entity\URL;
use App\Form\ShortenUrlFormType;
use App\Repository\URLRepository;
use App\Service\UrlManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class URLController extends AbstractController
{
    private $urlManager;
    private $urlRepository;

    public function __construct(UrlManager $urlManager, UrlRepository $urlRepository)
    {
        $this->urlManager = $urlManager;
        $this->urlRepository = $urlRepository;
    }

    #[Route('/', name: 'homepage')]
    public function index(Request $request): Response
    {
        $user = $this->getUser();

        $url = new Url();
        $form = $this->createForm(ShortenUrlFormType::class, $url);
        $form->handleRequest($request);

        $message = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $originalUrl = $url->getOriginalUrl();
            $customAlias = $form->get('customAlias')->getData();

            // Check if already shortened
            $existingUrl = $this->urlRepository->findOneBy(['originalUrl' => $originalUrl, 'user' => $user]);

            if ($existingUrl) {
                $message = sprintf('La URL "%s" ya ha sido acortada anteriormente.', $originalUrl);
            } else {
                $url = $this->urlManager->createUrl($originalUrl, $customAlias);
                $message = 'URL acortada exitosamente.';
            }
        }

        return $this->render('url/index.html.twig', [
            'urls' => $this->urlRepository->findBy(['user' => $user]),
            'form' => $form->createView(),
            'message' => $message,
        ]);
    }

    #[Route('/{shortUrlCode}', name: 'redirect_url')]
    public function externalRedirect(string $shortUrlCode, int $status = 302)
    {
        $url = $this->urlRepository->findOneBy(['shortUrlCode' => $shortUrlCode]);    
        if (!$url) {
            throw $this->createNotFoundException('URL no encontrada');
        }

        // Register access
        $url->getAnalytics()->incrementAccessCount();
        $this->urlRepository->save($url, true   );

        // Redirect
        header("Location: {$url->getOriginalUrl()}");
        exit();
    }  

    #[Route('/url/{id}', name: 'delete_url',  methods: ['DELETE'])]
    public function delete(Request $request, URL $url): Response
    {
        $this->urlManager->delete($url);
        return $this->redirectToRoute('homepage');
    }
}
