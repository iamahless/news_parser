<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
	/**
	 * @var PostRepository $postRepository
	 */
	private PostRepository $postRepository;

	public function __construct(PostRepository $postRepository)
	{
		$this->postRepository = $postRepository;
	}

	/**
     * @Route("/", name="app_home")
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
		$allPosts = $this->postRepository->createQueryBuilder('p')->getQuery();

		$posts = $paginator->paginate(
			$allPosts,
			$request->query->getInt('page', 1),
			10
		);

        return $this->render('home/index.html.twig', [
            'posts' => $posts,
        ]);
    }

	/**
	 * @Route("/posts/delete/{id}", name="app_post_delete")
	 */
	public function deleteBlog(Post $post, EntityManagerInterface $em): RedirectResponse
	{
		$em->remove($post);
		$em->flush();
		$this->addFlash('success', 'Post was deleted!');

		return $this->redirectToRoute('app_home');
	}
}
