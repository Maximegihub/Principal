packer {
  required_plugins {
    proxmox = {
      version = ">= 2.7.5""                     # Version du plugin utilisé# 
      source  = "github.com/hashicorp/proxmox"    #Plugins permettant de faire le lien entre notre script et l'api qui va déployer notre ressources#
    }
  }
}



source "proxmox-clone" "NOM_TEMPLATE_SOURCE" {
    # ID
    task_timeout = "15m"
    clone_vm = "NOM_TEMPLATE_SOURCE"
    proxmox_url = "https://SERVER_CIBLE/api_cible/json"
    username = ""
    token = ""                                          # Token d'authentification de votre utilisateur
    node = "Nom du noeud "
    insecure_skip_tls_verify = true	                          # Bypassé la vérification TLS#
    # Base ISO File configuration
    # System
    vm_name  = ""                                                  #Nommer votre template#
    vm_id  = ""                          
    scsi_controller = "virtio-scsi-single"                             #Controlleur du disque ISCI,IDE,SATA,SAS#
    ssh_password         = "votre_mot_de_passe"               
    ssh_timeout          = "20m"                
    ssh_username         = "votre_utilisateur"                 
     
    
    }

build {

   sources = ["source.proxmox-clone.VM-ML-DEB"]
   
   provisioner "shell" {                                                  
    inline = [
    "hostnamectl set-hostname maximel",                                     # Modifier le nom de la machine#
    "echo \"maxime ALL=(ALL) NOPASSWD:ALL\" | tee /etc/sudoers.d/maxime",       # Ne pas demander le mot de passe #
    "mkdir -p /home/maxime/.ssh/",                                                #Création du répertoire pour stocker la clé SSH#
    "echo \"ssh-rsa CLE PRIVEE = Nomdelordinateur \" >/home/maxime/.ssh/authorized_keys",    #Chemin ou sera stocké la clé ssh sur votre template#
    "apt-get update",                                                                           #Mise a jour du cache#                                                
    "apt-get install -y git",                                                                       #Installation de git#
    "mkdir -p /opt/git",                                                                               #Création d'un répértoire git#
    "cd /opt/git",                                                                                        #Se déplacer dans le répertoire#
    "git init --bare myrepo.git",                                                                           #Initialiser son repository#
    "git config --global user.name \"$Maximegihub\"",                                                        #Nom du compte github#
    "git config --global user.email \"$git_email\"",                                                             #Adresse email du compte github#
    "chown -R maxime:maxime /opt/git",                                                                                #Modifier le possesseur du fichier, le -R pour reccursif                                                  
    
    ]
  }
}
