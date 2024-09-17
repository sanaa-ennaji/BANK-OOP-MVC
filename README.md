## Brif8 : Optimisation et amélioration du projet E-Banking


Afin d'améliorer et optimiser son système de gestion, Morocco Banque a décidé de faire un upgrade de son système de gestion du procédural vers l'orienté objet avec quelques modifications au niveau de conception. Cette dernière vous a fait appel pour faire tous ces changements dans le système.

## Objectifs

1. **Upgrade du Système vers l'Orienté Objet**
   - Refactoriser le système existant pour adopter la programmation orientée objet (POO).

2. **Héritage des Comptes**
   - Implémenter les comptes comme étant soit des comptes Épargne, soit des comptes Courants, en utilisant l'héritage pour partager des comportements communs.

3. **Utilisation des Concepts de POO**
   - Intégrer les concepts fondamentaux de la programmation orientée objet dans le design du système.

4. **Traitement Métier Séparé des Modèles**
   - Assurer que le traitement métier ne réside pas dans les modèles (entités) mais dans une couche service. Créer des interfaces et leurs implémentations pour cette couche.

5. **Bonus : MVC**
   - Implémenter le modèle-vue-contrôleur (MVC) pour structurer l'application en séparant les préoccupations.

---

# Concepts de Programmation Orientée Objet (POO)

La programmation orientée objet est un paradigme qui utilise des concepts tels que l'encapsulation, l'héritage et le polymorphisme pour organiser le code de manière modulaire et réutilisable. Voici les concepts clés :

- **Objet :** Une instance d'une classe, combinant des données (attributs) et des méthodes (fonctions).
- **Classe :** Un modèle définissant la structure et le comportement d'un objet. Les objets sont créés à partir des classes.
- **Encapsulation :** Regroupement de données et de méthodes dans une unité, cachant les détails internes et exposant une interface.
- **Héritage :** Capacité d'une classe à hériter des propriétés et des méthodes d'une autre classe, facilitant la réutilisabilité du code.
- **Polymorphisme :** Capacité d'objets de différentes classes de répondre de manière uniforme à des messages ou des méthodes, souvent à travers le surchargement ou l'implémentation d'interfaces communes.
- **Abstraction :** Simplification d'un concept complexe en fournissant une interface claire tout en masquant les détails de l'implémentation.
- **Interface :** Collection de méthodes déclarées sans implémentation, fournissant un contrat que les classes peuvent implémenter.
- **Méthode :** Fonction associée à une classe, représentant le comportement de cette classe.
- **Attribut/Propriété :** Variable associée à une classe, représentant une caractéristique ou une donnée de l'objet de cette classe.
- **Constructeur :** Méthode spéciale appelée lors de la création d'un objet, utilisée pour initialiser ses propriétés.
- **Destructeur :** Méthode spéciale appelée lorsqu'un objet est détruit, utilisée pour libérer des ressources ou effectuer d'autres tâches de nettoyage.
- **Instance :** Objet spécifique créé à partir d'une classe.
- **Méthode Statique :** Méthode liée à la classe plutôt qu'à une instance particulière, accessible sans avoir besoin d'instancier la classe.
- **Surcharge :** Définition de plusieurs méthodes avec le même nom dans une classe, mais avec des signatures différentes.
- **Surcharge d'Opérateurs :** Redéfinition des opérateurs standard pour des types de données personnalisés.
- **Composition :** Création d'objets complexes en combinant plusieurs objets plus simples.
- **Agrégation :** Forme de composition où un objet peut exister indépendamment de l'autre.
- **Méthode Abstraite :** Méthode déclarée dans une classe mais sans implémentation, laissant aux sous-classes le soin de la fournir.
- **Classe Abstraite :** Classe qui ne peut pas être instanciée elle-même et qui sert souvent de modèle pour d'autres classes.
- **Visibilité (public, private, protected) :** Niveaux d'accès aux membres d'une classe, contrôlant leur visibilité depuis l'extérieur de la classe.

