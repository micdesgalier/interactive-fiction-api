<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Story;
use App\Models\Chapter;
use App\Models\Choice;

class InteractiveStorySeeder extends Seeder
{
    public function run(): void {
       // ─────────────── STORY 1 ───────────────
       $story1 = Story::create([
              'title'       => 'La Route de l\'Entrepreneur',
              'description' => 'Thomas, 28 ans, quitte son emploi pour lancer sa boutique d\'e-commerce d\'accessoires tech écologiques.',
              'created_by'  => 1,
       ]);

       $data1 = [
              1  => [
                     'Le Grand Départ',
                     'Thomas, 28 ans, vient de quitter son emploi stable pour lancer sa boutique d\'e-commerce spécialisée dans les accessoires tech écologiques. Il a quelques économies et doit décider comment démarrer.',
                     ['Investir la majorité de ses économies dans un stock important et une plateforme e-commerce personnalisée', 2],
                     ['Commencer petit avec une boutique sur une plateforme existante (Shopify, Etsy) et un stock limité', 3],
              ],
              2  => [
                     'L\'Investissement Ambitieux',
                     'Thomas a investi massivement dans sa plateforme et son stock. Le site est magnifique mais les ventes tardent à décoller malgré les coûts fixes importants.',
                     ['Investir dans une campagne marketing agressive pour attirer plus de clients', 4],
                     ['Réduire les coûts en renégociant avec les fournisseurs et optimiser le référencement naturel', 5],
              ],
              3  => [
                     'Les Débuts Modestes',
                     'Thomas a démarré sur Etsy avec un petit stock. Les coûts sont maîtrisés mais la croissance est lente.',
                     ['Diversifier sa gamme de produits pour attirer plus de clients', 6],
                     ['Se spécialiser davantage pour devenir une référence dans un créneau ultra-spécifique', 7],
              ],
              4  => [
                     'Le Pari Marketing',
                     'La campagne marketing a généré du trafic mais le retour sur investissement est mitigé et la trésorerie diminue rapidement.',
                     ['Persévérer et augmenter encore le budget marketing', 8],
                     ['Pivoter vers une stratégie de contenu et d\'influence moins coûteuse', 9],
              ],
              5  => [
                     'L\'Optimisation Stratégique',
                     'En réduisant les coûts et en améliorant le référencement, la rentabilité s\'améliore progressivement mais la croissance reste modérée.',
                     ['Approcher des investisseurs pour accélérer la croissance', 10],
                     ['Maintenir l\'indépendance et la croissance organique', 11],
              ],
              6  => [
                     'La Diversification',
                     'Thomas a élargi sa gamme, attirant plus de clients mais compliquant sa gestion de stock et sa communication.',
                     ['Structurer l\'entreprise en embauchant un assistant', 12],
                     ['Automatiser davantage les processus grâce à des outils numériques', 13],
              ],
              7  => [
                     'L\'Expert de Niche',
                     'La spécialisation porte ses fruits, Thomas commence à être reconnu comme expert dans son domaine mais le marché semble limité.',
                     ['Lancer une série de formations et conseils payants sur sa spécialité', 14],
                     ['Chercher à conquérir les marchés internationaux avec son produit de niche', 15],
              ],
              8  => [
                     'Le Gouffre Financier',
                     'Le budget marketing a explosé, les ventes ont légèrement augmenté mais insuffisamment pour couvrir les dépenses. La trésorerie est critique.',
                     ['Chercher un prêt d\'urgence pour maintenir l\'activité', 16],
                     ['Vendre une partie de l\'entreprise à un partenaire stratégique', 17],
              ],
              9  => [
                     'L\'Influence Digitale',
                     'La stratégie de contenu commence à porter ses fruits, la notoriété augmente et les coûts d\'acquisition baissent.',
                     ['Profiter de cette visibilité pour lancer une gamme premium', 18],
                     ['Développer des partenariats avec des influenceurs pour amplifier la croissance', 19],
              ],
              10 => [
                     'La Levée de Fonds',
                     'Thomas a convaincu des business angels d\'investir, lui donnant les moyens d\'accélérer mais avec une pression sur les résultats.',
                     ['Utiliser ces fonds pour développer un produit innovant breveté', 20],
                     ['Investir dans l\'expansion commerciale et le marketing', 21],
              ],
              11 => [
                     'La Croissance Maîtrisée',
                     'L\'entreprise est stable et rentable, mais Thomas se demande comment passer à l\'étape suivante.',
                     ['Investir ses bénéfices dans des cryptomonnaies pour diversifier', 22],
                     ['Ouvrir un magasin physique pour compléter sa présence en ligne', 23],
              ],
              12 => [
                     'L\'Équipe qui Grandit',
                     'Avec son nouvel assistant, Thomas peut déléguer et se concentrer sur la stratégie, mais la masse salariale pèse sur les finances.',
                     ['Continuer à recruter pour accélérer la croissance', 24],
                     ['Consolider l\'équipe actuelle avant d\'envisager d\'autres embauches', 25],
              ],
              13 => [
                     'L\'Automatisation',
                     'Les processus automatisés fonctionnent bien mais manquent parfois de flexibilité face à certaines demandes clients.',
                     ['Investir dans une IA pour personnaliser davantage l\'expérience client', 26],
                     ['Compléter l\'automatisation par un service client premium humain', 15],
              ],
              14 => [
                     'Le Business du Savoir',
                     'Les formations rencontrent un grand succès et génèrent des revenus complémentaires, mais prennent beaucoup de temps à Thomas.',
                     ['Faire des formations son activité principale et réduire la vente de produits', 27],
                     ['Recruter des formateurs pour développer cette activité en parallèle', 28],
              ],
              15 => [
                     'L\'Expansion Internationale',
                     'Les ventes internationales décollent mais génèrent des défis logistiques et réglementaires complexes.',
                     ['Ouvrir un bureau à l\'étranger pour gérer cette expansion', 29],
                     ['Travailler avec des distributeurs locaux dans chaque pays', 21],
              ],
              16 => [
                     'La Dette',
                     'Le prêt a temporairement sauvé l\'entreprise mais les échéances de remboursement approchent.',
                     ['Tenter de renégocier l\'échéancier avec la banque', 32],
                     ['Rechercher activement des investisseurs pour renflouer l\'entreprise', 17],
              ],
              17 => [
                     'Le Nouvel Associé',
                     'Le partenaire stratégique apporte des capitaux et de l\'expertise mais veut influencer la direction de l\'entreprise.',
                     ['Accepter la vision du partenaire pour une restructuration complète', 31],
                     ['Défendre fermement sa vision originelle malgré les tensions', 24],
              ],
              18 => [
                     'Le Positionnement Premium',
                     'La gamme premium rencontre un certain succès mais change l\'image de la marque et attire une clientèle différente.',
                     ['Assumer pleinement ce repositionnement haut de gamme', 31],
                     ['Maintenir un équilibre entre produits accessibles et premium', 26],
              ],
              19 => [
                     'La Stratégie d\'Influence',
                     'Les partenariats avec les influenceurs explosent les ventes mais certains partenaires créent des controverses.',
                     ['Établir une charte éthique stricte pour les collaborations futures', 25],
                     ['Maximiser l\'impact marketing quitte à prendre des risques d\'image', 33],
              ],
              20 => [
                     'L\'Innovation Protégée',
                     'Le développement du produit breveté prend plus de temps et d\'argent que prévu, inquiétant les investisseurs.',
                     ['Chercher des financements supplémentaires pour finaliser le produit', 32],
                     ['Lancer une version simplifiée pour générer des revenus rapidement', 23],
              ],
              21 => [
                     'L\'Expansion Commerciale',
                     'L\'expansion commerciale est un succès mais crée des tensions avec les premiers investisseurs qui voient leur part se diluer.',
                     ['Proposer un programme de rachat d\'actions aux investisseurs mécontents', 25],
                     ['Convaincre les investisseurs des bénéfices à long terme de cette stratégie', 31],
              ],
              22 => [
                     'Le Pari Crypto',
                     'Thomas a investi une partie des profits dans les cryptomonnaies, qui connaissent de fortes fluctuations.',
                     ['Vendre lors d\'une hausse pour sécuriser les gains', 33],
                     ['Maintenir l\'investissement en espérant une hausse plus importante', 33],
              ],
              23 => [
                     'Le Magasin Physique',
                     'Le magasin physique crée une expérience client appréciée mais les coûts fixes sont élevés.',
                     ['Développer un réseau de boutiques dans d\'autres villes', 28],
                     ['Transformer le magasin en showroom expérientiel avec événements', 27],
              ],
              24 => [
                     'La Structure Corporate',
                     'L\'entreprise compte maintenant plusieurs employés et doit se structurer davantage.',
                     ['Investir dans un siège social prestigieux pour attirer les talents', 32],
                     ['Privilégier le télétravail et une structure légère', 29],
              ],
              25 => [
                     'L\'Équipe Soudée',
                     'L\'équipe restreinte mais efficace permet une bonne rentabilité, mais certaines opportunités sont manquées par manque de ressources.',
                     ['Accepter un gros contrat qui nécessiterait d\'embaucher rapidement', 31],
                     ['Se concentrer sur les clients existants et la croissance organique', 31],
              ],
              26 => [
                     'L\'IA au Service du Client',
                     'L\'IA améliore considérablement l\'expérience client mais certains clients traditionnels sont réticents.',
                     ['Communiquer davantage sur les avantages de l\'IA', 29],
                     ['Maintenir une option de service 100% humain', 32],
              ],
              27 => [
                     'Le Changement de Business Model',
                     'Le showroom expérientiel transforme l\'entreprise en lieu de rencontre et d\'expérience.',
                     ['Développer des ateliers et formations en présentiel', 31],
                     ['Créer un concept franchisable pour d\'autres entrepreneurs', 31],
              ],
              28 => [
                     'L\'Académie Entrepreneuriale',
                     'L\'équipe de formateurs permet de développer une véritable académie, mais la qualité est inégale.',
                     ['Standardiser strictement le contenu des formations', 31],
                     ['Encourager chaque formateur à développer son approche unique', 31],
              ],
              29 => [
                     'Le Bureau International',
                     'Le bureau à l\'étranger permet de mieux gérer l\'expansion mais coûte cher et crée des défis de management à distance.',
                     ['Déménager partiellement à l\'étranger pour superviser directement', 32],
                     ['Recruter un directeur local expérimenté', 32],
              ],

              // Quatre épilogues finaux :
              30 => ['Succès Inespéré',  'Grâce à vos choix, l’entreprise a connu un succès inespéré et dépasse toutes ses espérances.',           null, null],
              31 => ['Croissance Stable', 'L’entreprise tourne correctement avec une croissance stable et une rentabilité saine pour Thomas.',     null, null],
              32 => ['Survie Difficile',  'L’entreprise survit mais reste en difficulté ; il faudra redoubler d’efforts pour tenir le cap.',     null, null],
              33 => ['Faillite',          'Malheureusement, l’entreprise n’a pas pu résister aux difficultés financières et a fait faillite.',     null, null],
       ];

       // création des chapitres + choix de la Story 1
       $this->createFromData($story1, $data1);

       // ─────────────── STORY 2 ───────────────
       $story2 = Story::create([
              'title'       => 'Aurore et la Conquête Spatiale',
              'description' => 'Aurore, jeune ingénieure passionnée d\'astronomie, se voit confier la mission de piloter le tout premier vol habité vers Mars.',
              'created_by'  => 1,
       ]);

       $data2 = [
              1  => [
              'Le Décollage Historique',
              'Après des mois d\'entraînement, Aurore grimpe à bord du vaisseau Orion. Les moteurs rugissent, la Terre s\'éloigne. Comment gérer ton stress ?',
              ['Suivre simplement le protocole à la lettre', 2],
              ['Improviser des techniques de respiration personnelles', 3],
              ],
              2  => [
              'Protocole Impeccable',
              'Tu suis chaque étape du manuel minutieusement. Tout se passe sans encombre… jusqu’à une alarme de surchauffe dans la turbine secondaire.',
              ['Activer le circuit de secours automatique', 4],
              ['Tenter une réparation manuelle (risqué)', 5],
              ],
              3  => [
              'Calme Instantané',
              'Tes propres exercices de respiration t’apaisent. Tu déjoues une première turbulence orbitale, mais l’équipage te reproche de ne pas suivre le manuel.',
              ['Rétablir la procédure officielle', 6],
              ['Continuer ta méthode, convaincue de son efficacité', 7],
              ],
              4  => [
              'Secours Performant',
              'Le circuit de secours refroidit la turbine. Cependant, la réserve d\'hydrogène baisse plus vite que prévu.',
              ['Rallumer la turbine principale immédiatement', 8],
              ['Économiser l\'hydrogène en réduisant la poussée', 9],
              ],
              5  => [
              'Réparation Dangereuse',
              'Tu ouvres le panneau, mais une étincelle crée un début d\'incendie. Tu parviens à éteindre les flammes, mais tu perds du temps précieux.',
              ['Accélérer pour rattraper le retard', 10],
              ['Faire une vérification complète avant de repartir', 11],
              ],
              6  => [
              'Retour au Manuel',
              'L’équipage reprend confiance en toi. La mission continue sans accroc, jusqu’à l’entrée dans l’atmosphère martienne.',
              ['Respecter la trajectoire prévue', 12],
              ['Ajuster un peu la trajectoire pour économiser du carburant', 13],
              ],
              7  => [
              'Méthode Inattendue',
              'Ton approche alternative impressionne les ingénieurs, mais crée des écarts dans la navigation.',
              ['Revenir au plan initial avant l’atterrissage', 14],
              ['Poursuivre malgré un risque accru de brûlage atmosphérique', 15],
              ],
              8  => [
              'Poussée Maximale',
              'Tu compenses la perte d’hydrogène par un surcroît de poussée. La rentrée est rude, mais tu te poses en douceur.',
              ['Déployer immédiatement les panneaux solaires', 16],
              ['Prendre le temps d’inspecter le vaisseau avant de sortir', 17],
              ],
              9  => [
              'Pilotage Économe',
              'Tu ralentis la descente pour économiser. L’atterrissage est délicat, mais réussi.',
              ['Ouvrir l’écoutille sans tarder', 18],
              ['Vérifier les niveaux de vie avant d’ouvrir', 19],
              ],
              10 => [
              'Course Contre la Montre',
              'Tu gagnes du temps mais la trajectoire souffre d\'irrégularités.',
              ['Corriger en pleine descente', 20],
              ['Faire confiance aux logiciels embarqués', 21],
              ],
              11 => [
              'Vérification Méticuleuse',
              'Tu stabilises le vaisseau, mais l’atterrissage est proche…',
              ['Agir rapidement à l’alarme suivante', 22],
              ['Attendre la confirmation du centre de contrôle', 23],
              ],
              12 => [
              'Trajectoire Parfaite',
              'Le vaisseau se pose exactement à l’endroit prévu. La mission semble un succès.',
              ['Publier immédiatement des images en direct', 24],
              ['Faire d’abord un rapport scientifique complet', 25],
              ],
              13 => [
              'Gain de Carburant',
              'Tu économises 5 % de carburant, mais l’angle d’entrée est trop raide.',
              ['Ajuster manuellement l’angle en plein vol', 26],
              ['Revenir à l’angle d’origine', 25],
              ],
              14 => [
              'Retour Sûr',
              'Tu choisis la sécurité et la descente reste stable.',
              ['Ouvrir l’écoutille sans attendre', 18],
              ['Faire un tour extérieur en combinaison', 27],
              ],
              15 => [
              'Brûlage Excessif',
              'Le bouclier chauffe plus que prévu, mais il résiste.',
              ['Pousser jusqu’à la limite', 26],
              ['Revenir à un plan plus prudent', 14],
              ],
              16 => [
              'Panneaux Déployés',
              'L’alimentation est rétablie, et le rover peut bientôt être déployé.',
              ['Démarrer l’exploration immédiate', 28],
              ['Analyser d’abord la stabilité du sol', 29],
              ],
              17 => [
              'Inspection Préalable',
              'Tu découvres une micro-fissure dans le blindage.',
              ['Réparer sur place (lent)', 30],
              ['Signaler et attendre un drone de secours', 31],
              ],
              18 => [
              'Premiers Pas',
              'Aurore foule le sol martien. Un moment historique.',
              ['Collecter un échantillon de sol', 32],
              ['Placer le drapeau et communiquer', 33],
              ],
              19 => [
              'Contrôle des Systèmes',
              'Les niveaux de vie sont stables, la mission continue.',
              ['Installer le laboratoire mobile', 28],
              ['Retour au module principal', 30],
              ],
              20 => [
              'Correction Dynamique',
              'Tu rétablis la trajectoire… au prix d’une forte consommation d’énergie.',
              ['Prioriser la mission scientifique', 31],
              ['Retourner à la base plus tôt', 32],
              ],
              21 => [
              'Confiance Logicielle',
              'Le logiciel corrige seul, et tout se passe bien.',
              ['Sortir explorer immédiatement', 28],
              ['Faire un rapport avant de sortir', 29],
              ],
              22 => [
              'Action Rapide',
              'Une manœuvre audacieuse te sauve d’une panne critique.',
              ['Lancer le rover tout de suite', 28],
              ['Stabiliser d’abord la base', 31],
              ],
              23 => [
              'Validation à Distance',
              'Le centre de contrôle valide ton plan, tout est OK.',
              ['Explorer la vallée voisine', 28],
              ['Installer des capteurs au camp', 29],
              ],
              24 => [
              'Succès Médiatique',
              'Le monde entier te voit triompher.',
              null, null
              ],
              25 => [
              'Rapport Scientifique',
              'Tu envoies des données cruciales pour l’humanité.',
              null, null
              ],
              26 => [
              'Ajustement Risqué',
              'L’angle corrigé te sauve, mais le vaisseau souffre.',
              null, null
              ],
              27 => [
              'Exploration Extérieure',
              'Tu captures des images inédites de Mars.',
              null, null
              ],
              28 => [
              'Exploration Réussie',
              'Les premiers échantillons sont prometteurs.',
              null, null
              ],
              29 => [
              'Installation Réussie',
              'La base est opérationnelle et stable.',
              null, null
              ],
              30 => ['Échec Mineur',     'La mission subit un revers, mais l’équipage est sain et sauf.', null, null],
              31 => ['Aide Spatiale',     'Un drone de secours arrive, permettant de poursuivre la mission.', null, null],
              32 => ['Retour Précoce',    'Vous rentrez sur Terre avant terme, riche d’enseignements.', null, null],
              33 => ['Triomphe Total',    'La mission dépasse les objectifs, ouvrant l’ère de la colonisation.', null, null],
       ];

       $this->createFromData($story2, $data2);

       // ─────────────── STORY 3 ───────────────
       $story3 = Story::create([
       'title'       => 'Le Royaume des Ombres',
       'description' => 'Aelya, jeune mage issue d’un lointain village montagneux, se lance dans une quête pour sauver le Royaume des Ombres d’une malédiction ancestrale.',
       'created_by'  => 1,
       ]);

       $data3 = [
       1  => [
              'L’Appel des Anciens',
              'Une voix mystérieuse résonne dans ton rêve : le Roi a besoin de ton aide pour lever la malédiction. Accepteras‑tu cette mission ?',
              ['Oui, je réponds immédiatement à l’appel', 2],
              ['Non, je veux d’abord m’entraîner davantage', 3],
       ],
       2  => [
              'Voyage Périlleux',
              'Tu sors de ton village et suis la vallée maudite. Bientôt, tu rencontres un groupe de bandits.',
              ['Tenter la négociation pacifique', 4],
              ['Utiliser ta magie pour les disperser', 5],
       ],
       3  => [
              'Entraînement Intense',
              'Tu passes des semaines à perfectionner tes sorts. Mais le temps presse, la malédiction s’étend.',
              ['Partir malgré tout sans te sentir prêt', 2],
              ['Rester pour parfaire tes compétences', 6],
       ],
       4  => [
              'Paix Fragile',
              'Les bandits acceptent de t’aider en échange d’une part de ton trésor. Vous progressez ensemble.',
              ['Continuer en groupe', 7],
              ['Les abandonner au prochain village', 8],
       ],
       5  => [
              'Puissance Brute',
              'Ta magie impressionne, mais les habitants t’observent avec crainte. Tu gagnes du temps.',
              ['Poursuivre seul(e)', 9],
              ['Retourner au village pour prouver tes bonnes intentions', 10],
       ],
       6  => [
              'Maîtrise Renforcée',
              'Ton pouvoir est désormais redoutable, mais beaucoup de villages sont déjà sous l’emprise de l’ombre.',
              ['Te hâter vers la capitale', 2],
              ['Éradiquer d’abord toutes les créatures de l’ombre', 11],
       ],
       7  => [
              'Alliés Inattendus',
              'Les bandits te montrent un raccourci secret. Tu gagnes un précieux avantage.',
              ['Emprunter le raccourci', 12],
              ['Rester sur la route principale, plus sûre', 13],
       ],
       8  => [
              'Trahison Amère',
              'Les bandits t’abandonnent et te tendent une embuscade.',
              ['Riposter avec magie', 5],
              ['Fuir à toutes jambes', 14],
       ],
       9  => [
              'Solitaire mais Libre',
              'Tu progresses seul(e) mais tombes dans un piège enchanté.',
              ['Briser le sortilège de l’intérieur', 15],
              ['Appeler les bandits à la rescousse', 4],
       ],
       10 => [
              'Accueil Méfiant',
              'Le village t’ouvre ses portes mais exige une épreuve en échange de leur soutien.',
              ['Relever le défi du forgeron', 16],
              ['Refuser et repartir seul(e)', 9],
       ],
       11 => [
              'Chasseur d’Ombres',
              'Tu anéantis de nombreuses créatures mais épuises tes réserves magiques.',
              ['Poursuivre malgré la fatigue', 17],
              ['Chercher un ancien sanctuaire pour te reposer', 18],
       ],
       12 => [
              'Passage Caché',
              'Le raccourci te mène rapidement à la cité royale, tu arrives avant l’aube.',
              ['Prévenir le roi immédiatement', 19],
              ['Trouver d’abord un conseil auprès des anciens', 20],
       ],
       13 => [
              'Route Sure',
              'Tu arrives à la cité en bon état mais avec un retard conséquent.',
              ['Exposer la situation au roi', 19],
              ['Chercher des informations dans la cité', 21],
       ],
       14 => [
              'Fuite Désespérée',
              'Tu parviens à t’échapper mais te perds dans la forêt interdite.',
              ['Utiliser ta magie pour te repérer', 22],
              ['Attendre secours des bandits', 4],
       ],
       15 => [
              'Libération Intérieure',
              'Tu brises le piège et gagnes en confiance.',
              ['Renforcer tes défenses magiques', 23],
              ['Marcher droit vers le château', 19],
       ],
       16 => [
              'Épreuve du Forgeron',
              'Tu forges une arme bénie par les anciens. Elle brille d’une aura bienfaisante.',
              ['L’emporter avec toi', 2],
              ['L’offrir aux bandits pour les rallier', 7],
       ],
       17 => [
              'Épuisement',
              'Tu t’écroules, tes forces te quittent.',
              null, null,
       ],
       18 => [
              'Sanctuaire Sacré',
              'Tu trouves un lieu ancien où récupérer toute ta magie.',
              ['Poursuivre ta route frais et dispos', 19],
              ['Rester pour étudier les runes', 23],
       ],
       19 => [
              'Face au Roi',
              'Le Roi te confie la relique ultime pour lever la malédiction.',
              ['Activer la relique immédiatement', 24],
              ['Étudier d’abord son fonctionnement', 25],
       ],
       20 => [
              'Sagesse des Anciens',
              'Les anciens t’enseignent un rituel puissant.',
              ['Lancer le rituel tout de suite', 24],
              ['Attendre la pleine lune pour plus de puissance', 26],
       ],
       21 => [
              'Intrigues Royales',
              'Les conseillers sont divisés sur ta venue.',
              ['Convaincre par la parole', 24],
              ['Démontrer ta magie en duel', 27],
       ],
       22 => [
              'Guide Céleste',
              'Un esprit ancestral te guide hors de la forêt.',
              ['Le suivre jusqu’au château', 19],
              ['Le remercier et poursuivre seul(e)', 9],
       ],
       23 => [
              'Maîtrise Suprême',
              'Ta magie atteint un nouveau palier.',
              ['Te présenter au roi avec assurance', 19],
              ['Éradiquer toutes les ombres alentours', 11],
       ],

       // Quatre épilogues finaux pour STORY 3
       24 => ['Victoire Radieuse',    'Grâce à ton courage, la malédiction est levée et le Royaume des Ombres renaît.',     null, null],
       25 => ['Savoir Préservé',      'Tu as sauvé le royaume en consignant l’ancien savoir pour les générations futures.', null, null],
       26 => ['Puissance Retardée',   'Le rituel manqué retarde la libération ; la lutte se prolongera.',                   null, null],
       27 => ['Défi Magistral',       'Ta démonstration de magie impressionne mais polarise le royaume.',                     null, null],
       ];

       $this->createFromData($story3, $data3);

       }

       /**
        * Helper pour créer chapitres & choix à partir
        * d'un array $data structuré comme ci-dessus.
        */
       protected function createFromData(Story $story, array $data): void
       {
              // 1) Création des chapitres
              $chapterMap = [];
              foreach ($data as $order => $item) {
                     // on s'assure que $item a toujours 4 éléments : [title, content, choixA, choixB]
                     [ $title, $content ] = $item;
                     $chapterMap[$order] = Chapter::create([
                     'story_id' => $story->id,
                     'order'    => $order,
                     'title'    => $title,
                     'content'  => $content,
                     ]);
              }

              // 2) Création des choix
              foreach ($data as $order => $item) {
                     // on “pad” l’array pour avoir au moins 4 éléments
                     [$title, $content, $choiceA, $choiceB] = array_pad($item, 4, null);

                     $chapter = $chapterMap[$order];
                     foreach ([$choiceA, $choiceB] as $c) {
                     if (! $c) {
                            continue;
                     }
                     Choice::create([
                            'chapter_id'        => $chapter->id,
                            'text'              => $c[0],
                            'target_chapter_id' => $chapterMap[$c[1]]->id,
                            'impact'            => $c[2] ?? 0,
                     ]);
                     }
              }
       }
}