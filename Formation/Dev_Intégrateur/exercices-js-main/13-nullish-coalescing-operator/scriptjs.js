/* Quelle est la valeur de retour ce code ?
let banane;
alert(banane ?? "pomme");

/ Resultat : l'alert va afficher pomme

Quelle est la valeur de retour ce code ?

let banane = "Trop bon";

alert(banane ?? "pomme");

Résultat : l'alert va afficher trop bon

let pomme = null;
let poire = "Trop bon !";
let banane = null;


alert(pomme || poire || banane || "pas bon.");

Resultat : il va afficher trop bon car la varialble poire à une valeur
comparé a banane et pomme 

L'opérateur "??" retourne 
L'opérateur && est utilisé avec des valeurs booléénes, renvoi true si toute
les comparaisons sont évaluées a true ou false.
L'opérateur || : renvoi true ou false si au moin une des comparaison est évalué a true ou false


let fruit = ("poire" && "pomme") ?? "banane"

alert(fruit)

Resultat ; Va afficher pomme uniquement 