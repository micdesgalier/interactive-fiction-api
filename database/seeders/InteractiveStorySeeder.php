<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Story;
use App\Models\Chapter;
use App\Models\Choice;

class InteractiveStorySeeder extends Seeder
{
    public function run(): void
    {
        // 1) Création de la Story
        $story = Story::create([
            'title'       => 'La Route de l\'Entrepreneur',
            'description' => 'Thomas, 28 ans, quitte son emploi pour lancer sa boutique d\'e-commerce d\'accessoires tech écologiques.',
            'created_by'  => 1, // adapte si nécessaire
        ]);

        // 2) Définition des chapitres + choix
        $data = [
            1  => ['Le Grand Départ', 'Thomas, 28 ans, vient de quitter son emploi stable pour lancer sa boutique d\'e-commerce spécialisée dans les accessoires tech écologiques. Il a quelques économies et doit décider comment démarrer.',
                   ['Investir la majorité de ses économies dans un stock important et une plateforme e-commerce personnalisée', 2],
                   ['Commencer petit avec une boutique sur une plateforme existante (Shopify, Etsy) et un stock limité', 3]
            ],
            2  => ['L\'Investissement Ambitieux', 'Thomas a investi massivement dans sa plateforme et son stock. Le site est magnifique mais les ventes tardent à décoller malgré les coûts fixes importants.',
                   ['Investir dans une campagne marketing agressive pour attirer plus de clients', 4],
                   ['Réduire les coûts en renégociant avec les fournisseurs et optimiser le référencement naturel', 5]
            ],
            3  => ['Les Débuts Modestes', 'Thomas a démarré sur Etsy avec un petit stock. Les coûts sont maîtrisés mais la croissance est lente.',
                   ['Diversifier sa gamme de produits pour attirer plus de clients', 6],
                   ['Se spécialiser davantage pour devenir une référence dans un créneau ultra-spécifique', 7]
            ],
            4  => ['Le Pari Marketing', 'La campagne marketing a généré du trafic mais le retour sur investissement est mitigé et la trésorerie diminue rapidement.',
                   ['Persévérer et augmenter encore le budget marketing', 8],
                   ['Pivoter vers une stratégie de contenu et d\'influence moins coûteuse', 9]
            ],
            5  => ['L\'Optimisation Stratégique', 'En réduisant les coûts et en améliorant le référencement, la rentabilité s\'améliore progressivement mais la croissance reste modérée.',
                   ['Approcher des investisseurs pour accélérer la croissance', 10],
                   ['Maintenir l\'indépendance et la croissance organique', 11]
            ],
            6  => ['La Diversification', 'Thomas a élargi sa gamme, attirant plus de clients mais compliquant sa gestion de stock et sa communication.',
                   ['Structurer l\'entreprise en embauchant un assistant', 12],
                   ['Automatiser davantage les processus grâce à des outils numériques', 13]
            ],
            7  => ['L\'Expert de Niche', 'La spécialisation porte ses fruits, Thomas commence à être reconnu comme expert dans son domaine mais le marché semble limité.',
                   ['Lancer une série de formations et conseils payants sur sa spécialité', 14],
                   ['Chercher à conquérir les marchés internationaux avec son produit de niche', 15]
            ],
            8  => ['Le Gouffre Financier', 'Le budget marketing a explosé, les ventes ont légèrement augmenté mais insuffisamment pour couvrir les dépenses. La trésorerie est critique.',
                   ['Chercher un prêt d\'urgence pour maintenir l\'activité', 16],
                   ['Vendre une partie de l\'entreprise à un partenaire stratégique', 17]
            ],
            9  => ['L\'Influence Digitale', 'La stratégie de contenu commence à porter ses fruits, la notoriété augmente et les coûts d\'acquisition baissent.',
                   ['Profiter de cette visibilité pour lancer une gamme premium', 18],
                   ['Développer des partenariats avec des influenceurs pour amplifier la croissance', 19]
            ],
            10 => ['La Levée de Fonds', 'Thomas a convaincu des business angels d\'investir, lui donnant les moyens d\'accélérer mais avec une pression sur les résultats.',
                   ['Utiliser ces fonds pour développer un produit innovant breveté', 20],
                   ['Investir dans l\'expansion commerciale et le marketing', 21]
            ],
            11 => ['La Croissance Maîtrisée', 'L\'entreprise est stable et rentable, mais Thomas se demande comment passer à l\'étape suivante.',
                   ['Investir ses bénéfices dans des cryptomonnaies pour diversifier', 22],
                   ['Ouvrir un magasin physique pour compléter sa présence en ligne', 23]
            ],
            12 => ['L\'Équipe qui Grandit', 'Avec son nouvel assistant, Thomas peut déléguer et se concentrer sur la stratégie, mais la masse salariale pèse sur les finances.',
                   ['Continuer à recruter pour accélérer la croissance', 24],
                   ['Consolider l\'équipe actuelle avant d\'envisager d\'autres embauches', 25]
            ],
            13 => ['L\'Automatisation', 'Les processus automatisés fonctionnent bien mais manquent parfois de flexibilité face à certaines demandes clients.',
                   ['Investir dans une IA pour personnaliser davantage l\'expérience client', 26],
                   ['Compléter l\'automatisation par un service client premium humain', 15]
            ],
            14 => ['Le Business du Savoir', 'Les formations rencontrent un grand succès et génèrent des revenus complémentaires, mais prennent beaucoup de temps à Thomas.',
                   ['Faire des formations son activité principale et réduire la vente de produits', 27],
                   ['Recruter des formateurs pour développer cette activité en parallèle', 28]
            ],
            15 => ['L\'Expansion Internationale', 'Les ventes internationales décollent mais génèrent des défis logistiques et réglementaires complexes.',
                   ['Ouvrir un bureau à l\'étranger pour gérer cette expansion', 29],
                   ['Travailler avec des distributeurs locaux dans chaque pays', 21]
            ],
            16 => ['La Dette', 'Le prêt a temporairement sauvé l\'entreprise mais les échéances de remboursement approchent.',
                   ['Tenter de renégocier l\'échéancier avec la banque', 30],
                   ['Rechercher activement des investisseurs pour renflouer l\'entreprise', 17]
            ],
            17 => ['Le Nouvel Associé', 'Le partenaire stratégique apporte des capitaux et de l\'expertise mais veut influencer la direction de l\'entreprise.',
                   ['Accepter la vision du partenaire pour une restructuration complète', 30],
                   ['Défendre fermement sa vision originelle malgré les tensions', 24]
            ],
            18 => ['Le Positionnement Premium', 'La gamme premium rencontre un certain succès mais change l\'image de la marque et attire une clientèle différente.',
                   ['Assumer pleinement ce repositionnement haut de gamme', 30],
                   ['Maintenir un équilibre entre produits accessibles et premium', 26]
            ],
            19 => ['La Stratégie d\'Influence', 'Les partenariats avec les influenceurs explosent les ventes mais certains partenaires créent des controverses.',
                   ['Établir une charte éthique stricte pour les collaborations futures', 25],
                   ['Maximiser l\'impact marketing quitte à prendre des risques d\'image', 30]
            ],
            20 => ['L\'Innovation Protégée', 'Le développement du produit breveté prend plus de temps et d\'argent que prévu, inquiétant les investisseurs.',
                   ['Chercher des financements supplémentaires pour finaliser le produit', 30],
                   ['Lancer une version simplifiée pour générer des revenus rapidement', 23]
            ],
            21 => ['L\'Expansion Commerciale', 'L\'expansion commerciale est un succès mais crée des tensions avec les premiers investisseurs qui voient leur part se diluer.',
                   ['Proposer un programme de rachat d\'actions aux investisseurs mécontents', 25],
                   ['Convaincre les investisseurs des bénéfices à long terme de cette stratégie', 30]
            ],
            22 => ['Le Pari Crypto', 'Thomas a investi une partie des profits dans les cryptomonnaies, qui connaissent de fortes fluctuations.',
                   ['Vendre lors d\'une hausse pour sécuriser les gains', 30],
                   ['Maintenir l\'investissement en espérant une hausse plus importante', 30]
            ],
            23 => ['Le Magasin Physique', 'Le magasin physique crée une expérience client appréciée mais les coûts fixes sont élevés.',
                   ['Développer un réseau de boutiques dans d\'autres villes', 28],
                   ['Transformer le magasin en showroom expérientiel avec événements', 27]
            ],
            24 => ['La Structure Corporate', 'L\'entreprise compte maintenant plusieurs employés et doit se structurer davantage.',
                   ['Investir dans un siège social prestigieux pour attirer les talents', 30],
                   ['Privilégier le télétravail et une structure légère', 29]
            ],
            25 => ['L\'Équipe Soudée', 'L\'équipe restreinte mais efficace permet une bonne rentabilité, mais certaines opportunités sont manquées par manque de ressources.',
                   ['Accepter un gros contrat qui nécessiterait d\'embaucher rapidement', 30],
                   ['Se concentrer sur les clients existants et la croissance organique', 30]
            ],
            26 => ['L\'IA au Service du Client', 'L\'IA améliore considérablement l\'expérience client mais certains clients traditionnels sont réticents.',
                   ['Communiquer davantage sur les avantages de l\'IA', 29],
                   ['Maintenir une option de service 100% humain', 30]
            ],
            27 => ['Le Changement de Business Model', 'Le showroom expérientiel transforme l\'entreprise en lieu de rencontre et d\'expérience.',
                   ['Développer des ateliers et formations en présentiel', 30],
                   ['Créer un concept franchisable pour d\'autres entrepreneurs', 30]
            ],
            28 => ['L\'Académie Entrepreneuriale', 'L\'équipe de formateurs permet de développer une véritable académie, mais la qualité est inégale.',
                   ['Standardiser strictement le contenu des formations', 30],
                   ['Encourager chaque formateur à développer son approche unique', 30]
            ],
            29 => ['Le Bureau International', 'Le bureau à l\'étranger permet de mieux gérer l\'expansion mais coûte cher et crée des défis de management à distance.',
                   ['Déménager partiellement à l\'étranger pour superviser directement', 30],
                   ['Recruter un directeur local expérimenté', 30]
            ],
            30 => ['Épilogue', 'Selon le parcours emprunté, Thomas peut se retrouver dans différentes situations finales. Choix multiples finaux.',
                   null,
                   null
            ],
        ];

        // 3) Passe 1 : création des chapitres
       $createdChapters = [];
       foreach ($data as $order => [$title, $content, , ]) {
              $createdChapters[$order] = Chapter::create([
              'story_id' => $story->id,
              'order'    => $order,
              'title'    => $title,
              'content'  => $content,
              ]);
       }

       // 4) Passe 2 : création des choix
       foreach ($data as $order => [$title, $content, $choiceA, $choiceB]) {
              $chapter = $createdChapters[$order];

              foreach ([$choiceA, $choiceB] as $choice) {
              if (! $choice) {
                     continue;
              }
              Choice::create([
                     'chapter_id'        => $chapter->id,
                     'text'              => $choice[0],
                     'target_chapter_id' => $createdChapters[$choice[1]]->id,
                     'impact'            => $choice[2] ?? 0,
              ]);
              }
       }
    }
}