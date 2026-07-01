<?php 




$categories = [

   0 =>      [
            "code" => "coo0",
            "nom" => "categorie0",
            "produits" => [
                  0 => [
                    "nom" => "produit1",
                    "reference" => "ref1",
                    "prix" => 3000,
                    "quantite" => 5 
                  ],
                  1 => [
                    "nom" => "produit2",
                    "reference" => "ref2",
                    "prix" => 2000,
                    "quantite" => 3 
                  ]
            ]
         ],
   1 =>      [
            "code" => "coo1",
            "nom" => "categorie1",
            "produits" => []
         ]
];

//2
function afficheCategorieSansProduit(array $categories): void{
    foreach ($categories as  $categorie ) {
        if (empty($categorie["produits"])) {
            echo $categorie["nom"]."\n";
        }
    }
 }
 afficheCategorieSansProduit($categories);

//3
 function saisieChaine(string $message): string {
     return readline($message);  
 }

 function champObligatoire(string $value,string $message): bool{
    if (empty($value)) {
        echo $message."\n";
        return  false;
    }
        return true;
 }

 function rechercheCategorieParCle(array $categories, string $key, string $value): int|bool {
    foreach ($categories as $index  => $categorie ) {
        if (($categorie[$key]) === $value) {
            return $index ;
        }
    } 
    return false;
 }

 function saisieChampObligatoireEtUnique(array $categories,string $smsSaisie, string $smsError,string $key): string{
        
    $valueIsValid = true;
    do {   
        $value = saisieChaine($smsSaisie);
        $valueIsValid = champObligatoire($value,$smsError);
        if($valueIsValid){     
            $valueIsValid =rechercheCategorieParCle($categories,$key,$value);
        }
    } while (!$valueIsValid);
    return $value;
 }

 function enregistrerCategorie(): void{
    global $categories;
    $code = saisieChampObligatoireEtUnique($categories,"Entrez le code :", "champs obligatoire : ", "code");
    $nom = saisieChampObligatoireEtUnique($categories,"Entrez le nom :", "champs obligatoire : ", "nom");

    $categorie  =   [
            "code" => $code,
            "nom" => $nom,
            "produits" => []
         ];

    $categories[] = $categorie;
 }
 // 4: ajouter un produit à une catégorie

function saisieChampObligatoire(string $smsSaisie, string $smsError): string {
    do {
        $value = saisieChaine($smsSaisie);
        $valueIsValid = champObligatoire($value, $smsError);
    } while (!$valueIsValid);
    return $value;
}

function saisieEntierPositif(string $smsSaisie): int {
    do {
        $value = (int) saisieChaine($smsSaisie);
    } while ($value <= 0);
    return $value;
}

function saisirProduit(): array {
    $nom = saisieChampObligatoire("Entrez le nom du produit : ", "le nom est obligatoire");
    $reference = saisieChampObligatoire("Entrez la reference : ", "la reference est obligatoire");
    $prix = saisieEntierPositif("Entrez le prix : ");
    $quantite = saisieEntierPositif("Entrez la quantite : ");
    return [
        "nom" => $nom,
        "reference" => $reference,
        "prix" => $prix,
        "quantite" => $quantite
    ];
}

function ajouterProduit(): void {
    global $categories;
    $code = saisieChaine("Entrez le code de la categorie : ");
    $index = rechercheCategorieParCle($categories, "code", $code);
    if ($index !== false) {
        $produit = saisirProduit();
        $categories[$index]["produits"][] = $produit;
    } else {
        echo "désolé, la categorie n'existe pas...\n";
    }
}

ajouterProduit();
?>