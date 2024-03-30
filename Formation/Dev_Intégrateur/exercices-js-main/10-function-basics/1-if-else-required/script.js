// La fonction fonctionnera-t-elle différemment si else est supprimé ?

function checkAge(age) {
      if (age > 18) {
        return true;
      }
    *!*
      // ...
      return confirm('Did parents allow you?');
    */!*
    }

  // Oui si l'age est inférieur à 18 il n'affichera pas Did parents allow you? comparer au premier 
  // exemple car le else est manquant