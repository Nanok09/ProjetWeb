# Ce fichier a pour but de clarifier le shéma pour interagir avec l'API


## Principe général :

On effectue uniquement des Requêtes à la page concernée (pour l'instant /libs/sportbnbapi). Ces requêtes utilisent la méthode GET et comprennent toutes un paramètre action.

action: -list_terrains
        -get_terrain_info
        -get_recommandations


Chaque action peut/doit recevoir une liste de parametres optionels:

action = list_terrains:
        - sport = tennis -- chaine de caractere permettant d'identifier un sport parmis un certains set de sports. La chaine doit être pré déterminée, peut être il vaudrait mieux utiliser un genre d'id
        - user_location =lat,long  --  une chaine de caractere décrivant la position géographique de l'utilisateur 
        - distance_max=5 --  une chaine de caractère représentant le nombre de km max autorisés pour les terrains à afficher 
        - accept_public = no -- ne pas recevoir des propositions de terrains publics (par défaut on en recoit)
        - accept_private = no --  ne pas recevoir des propositions de terrains (par défaut on en recoit)

