# Ce fichier a pour but de clarifier le schéma pour interagir avec l'API

## Principe général :

On effectue uniquement des Requêtes à la page concernée (pour l'instant /libs/api.php). Ces requêtes utilisent la méthode POST et comprennent toutes un paramètre action.

action:

* get_list_terrains
* get_terrain_info
* get_recommandations

# Partie requete à l'API

Chaque action peut/doit recevoir une liste de parametres optionels:

* action = get_list_places:

  + sport = tennis -- chaine de caractere permettant d'identifier un sport parmis un certains set de sports. La chaine doit être pré déterminée, peut être il vaudrait mieux utiliser un genre d'id
  + user_location_lat =lat -- une chaine de caractere décrivant la position géographique de l'utilisateur (lattitude)
  + user_location_long=long -- une chaine de caractere décrivant la position géographique de l'utilisateur (longitude)
  + distance_max=5 -- une chaine de caractère représentant le nombre de km max autorisés pour les terrains à afficher
  + accept_public = no -- ne pas recevoir des propositions de terrains publics (par défaut on en recoit)
  + accept_private = no -- ne pas recevoir des propositions de terrains (par défaut on en recoit)
  + prix_min=5 -- str représentant le prix minimal (par défaut 0)
  + prix_max=6 -- str représentant le prix max (par défaut infini)

* action = get_place_info

  + terrain_id = id -- str de l'id du terrain (paramètre obligatoire!)

* action = get_recommandations (plus tard)

  + user_location_lat=lat
  + user_location_long=long

* action = add_note

  + id_place=id -- str représentant l'id du terrain auquel la note est rattachée
  + note= note -- str représentant la note

* action = modify_note

  + id_place = id -- str représentant l'id du terrain auquel la note est rattachée
  + note= note -- str représentant la note

* action = delete_note

  + id_place = id -- str représentant l'id du terrain auquel la note est rattachée

* action = add_comment

  + id_place = id -- str représentant l'id du terrain auquel la note est rattachée
  + comment= comment -- str représentant le commentaire

* action = modify_comment

  + id_comment = id -- str représentant l'id du commentaire
  + comment= comment -- str représentant le commentaire

* action = delete_comment

  + id_comment = id -- str représentant l'id du commentaire

* action = address_research
  + address = addresse -- str représentant l'adresse à trouver

# Partie réponse de l'API

### Format général de la réponse :

``` javascript
{
    version: @float numéro_version,
    status: @int numéro_du statut,
    success: @bool success,
    data: {}
}
```

### Format de data en fonction des différentes actions demandées

* action = get_list_places

``` 

        data : [{
                coordinates: {lat:lat, long:long},
                name: @str,
                id: @int,
                photos: [nom_fichier_1,...,nom_fichier_n],
                sport: @str,
                private: @bool,
                price: @float,
                note: @float (c'est la note moyenne des users),
                dispo: @int, false si private=false,
        },...,{}]
```

* action = get_place_info

``` 

        data = {
                coordinates: {lat:lat, long:long},
                name: @str,
                id: @int,
                photos: [nom_fichier_1,...,nom_fichier_n],
                sport: @str,
                private: @bool,
                price: @float,
                note: {mean: @float (c'est la note moyenne des users), nb_notes: @int}
                dispo: @int, false si private=false,
                description: @str
                comments: [{
                        id_comment: @int
                        author: @str
                        content: @str
                        timestamp: @int
                },...,{}]
        }
```

* action = get_recommandations

  pareil que: action = get_list_places

* action = add_note

  data: Undefined

* action = modify_note

  data: Undefined

* action = delete_note

  data: Undefined

* action = add_comment

``` 

        data: {
                id_comment: @int
                timestamp: @int
        }
```

* action = modify_comment

``` 

        data: {
                timestamp: @int
        }
```

* action = delete_comment

  data: Undefined

* action = address_research

``` 

        data: [{
                coordinates: {lat:lat,long:long},
                address : @str (représentant le nom complet de l'adresse ),
        },...,{}]
```

# Exemples

* action = add_note / modify_note

``` javascript
$.post('libs/api.php', {
    action: "add_note",
    id_place: 2,
    note: 4
}, function(res) {
    console.log(res)
}, "json")
```

* action = delete_note

``` javascript
$.post('libs/api.php', {
    action: "delete_note",
    id_place: 1
}, function(res) {
    console.log(res)
}, "json")
```

* action = add_comment

``` javascript
$.post('libs/api.php', {
    action: "add_comment",
    id_place: 1,
    comment: "texte du commentaire"
}, function(res) {
    console.log(res)
}, "json")
```

 Réponse

``` javascript
{
    "version": 1.1,
    "success": true,
    "status": 200,
    "data": {
        "timestamp": 1618136846,
        "id_comment": "4"
    }
}
```

Pour transformer le timestamp en chaîne de caractères lisible :

``` javascript
new Date(res.data.timestamp * 1000).toLocaleString()
```
