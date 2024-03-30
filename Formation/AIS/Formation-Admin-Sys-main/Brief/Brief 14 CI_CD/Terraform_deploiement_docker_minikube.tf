provider "vsphere" {
  user           = "Maxime
  password       = "votre_mot_de_passe_vsphere"
  vsphere_server = "guTG%i~1cHS%3l4\G&Ji"
  allow_unverified_ssl = false
}

resource "null_resource" "docker_installation" {
  provisioner "remote-exec" {
    inline = [
      "sudo apt-get update",
      "curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg",
      "echo 'deb [arch=amd64 signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable' | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null",
      "sudo apt-get update",
      "sudo apt-get install -y docker-ce docker-ce-cli containerd.io",
      "sudo systemctl start docker",
      "sudo systemctl enable docker",
      "sudo docker pull hello-world",
      "sudo docker run hello-world",
      "sudo apt-get install -y openssh-server",  # Installation du serveur SSH
    ]
    connection {
      host     = vsphere_virtual_machine.example.guest_ip_addresses[0]
      type     = "ssh"
      user     = "votre_utilisateur_vm"
      password = "votre_mot_de_passe_vm"
    }
  }

  triggers = {
    always_run = "${timestamp()}"
  }

  provisioner "remote-exec" {
    inline = [
      # Ajout de votre clé SSH à authorized_keys
      "echo 'votre_clé_ssh' >> ~/.ssh/authorized_keys",
      "chmod 600 ~/.ssh/authorized_keys",
      "chmod 700 ~/.ssh",
      # Configuration de SSH pour autoriser la connexion par clé uniquement
      "sudo sed -i 's/#PasswordAuthentication yes/PasswordAuthentication no/g' /etc/ssh/sshd_config",
      "sudo systemctl restart sshd",  # Redémarrage du service SSH
    ]
    connection {
      host     = vsphere_virtual_machine.example.guest_ip_addresses[0]
      type     = "ssh"
      user     = "votre_utilisateur_vm"
      password = "votre_mot_de_passe_vm"
    }
  }
}

resource "docker_container" "jenkins" {
  name  = "jenkins-container"
  image = "jenkins/jenkins:lts"
  ports {
    internal = 8080
    external = 8080
  }
  network_mode = "bridge"  # Utilisez "bridge" si vous ne spécifiez pas de réseau personnalisé
  restart = "always"       # Redémarrer toujours le conteneur en cas d'échec
  extra_hosts = {
    "jenkins.local" = "192.168.60.x"  # Remplacez 192.168.60.x par l'IP souhaitée
  }
  # ... d'autres paramètres personnalisés si nécessaire
}
