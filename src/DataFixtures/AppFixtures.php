<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Catagory;
use App\Entity\Comment;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // --- Categories ---
        $categoryNames = [
            'Matériel informatique',
            'Développement',
            'Admin Serveur',
        ];
 
        /** @var Catagory[] $categories */
        $categories = [];
        foreach ($categoryNames as $name) {
            $category = new Catagory();
            $category->setTitre($name);
            $manager->persist($category);
            $categories[$name] = $category;
        }
 
        $articleData = [
            [
                'title'      => 'Choisir son premier serveur dédié',
                'content'    => 'Un tour des critères à regarder avant de louer un serveur dédié : CPU, RAM, stockage NVMe et bande passante.',
                'categories' => ['Matériel informatique', 'Admin Serveur'],
            ],
            [
                'title'      => 'Débuter avec Symfony 6.4',
                'content'    => 'Installation, structure des dossiers, contrôleurs et routes. Le minimum pour comprendre comment une requête traverse le framework.',
                'categories' => ['Développement'],
            ],
            [
                'title'      => 'Sécuriser un accès SSH',
                'content'    => 'Désactiver le login root, passer aux clés plutôt qu\'aux mots de passe et changer le port par défaut. Les bases avant d\'exposer une machine.',
                'categories' => ['Admin Serveur', 'Développement'],
            ],
        ];
 
        /** @var Article[] $articles */
        $articles = [];
        foreach ($articleData as $data) {
            $article = new Article();
            $article->setTitre($data['title']);
            $article->setContenu($data['content']);
            foreach ($data['categories'] as $catName) {
                $article->addCatagory($categories[$catName]);
            }
            $manager->persist($article);
            $articles[] = $article;
        }
 
        // --- Comments (createdAt is set automatically by the PrePersist callback) ---
        $commentsData = [
            ['article' => 0, 'username' => 'alice',   'content' => 'Merci, ça m\'a aidé à choisir.'],
            ['article' => 0, 'username' => 'bob',     'content' => 'Et pour le refroidissement, un conseil ?'],
            ['article' => 1, 'username' => 'charlie', 'content' => 'Enfin une explication claire des routes.'],
            ['article' => 2, 'username' => 'dana',    'content' => 'Le coup du port par défaut, classique mais efficace.'],
        ];
 
        foreach ($commentsData as $data) {
            $comment = new Comment();
            $comment->setUsername($data['username']);
            $comment->setContent($data['content']);
            $comment->setArticle($articles[$data['article']]);
            $manager->persist($comment);
        }


        $manager->flush();
    }
}
