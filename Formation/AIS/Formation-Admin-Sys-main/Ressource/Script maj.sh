#!/bin/bash

# Informations d'authentification SSH
username="votre_nom_utilisateur"
password="votre_mot_de_passe"

# Liste des adresses IP ou des noms d'hôte des machines virtuelles
vms=("192.168.1.100" "192.168.1.101")

# Chemin local vers le script à exécuter sur les machines distantes
script_path="D:\AIS\Scriptmaj.sh"

# Boucle sur la liste des machines virtuelles
for vm in "${vms[@]}"; do
  echo "Exécution du script sur la machine virtuelle : $vm"
  
  # Exécution du script à distance via SSH
  sshpass -p "$password" ssh -o StrictHostKeyChecking=no "$username"@"$vm" "bash -s" < "$script_path"
done

# Modifier le fichier sources.list
sudo sed -i 's|old-repo|bookworm|g' /etc/apt/sources.list

# Mettre à jour les paquets
sudo apt-get update

# Effectuer une mise à niveau du système
sudo apt-get dist-upgrade -y

# Envoyer un e-mail
email="larrouquerem@gmail.com"
subject="Mise à jour du système terminée"
message="La mise à jour du système est terminée. Veuillez vérifier le serveur pour plus de détails."

echo "$message" | mail -s "$subject" "$larrouquerem@gmail.com"