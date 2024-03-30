# Providers utilisés pour Proxmox => Telmate

terraform {
    required_providers {
        proxmox = {
            source  = "Telmate/proxmox"
            version = "2.9.14"
        }
    }
}

# Informations de connexion Provider utilisées pour la connexion à Proxmox

provider "proxmox" {
    pm_api_url         = "http://192.168.50.50:8006/api2/json"
    pm_api_token_id    = "Maxime@pve!Proxmox"
    pm_api_token_secret = "2f49ec4f-bcc2-4eda-a029-577eb30f0bb4"
    #pm_tls_insecure = true  //for Proxmox self-signed certificate WUI
}

# Déclaration des noms des machines virtuelles
variable "vm_names" {
    type    = list(string)
    default = ["SRV-MINIKUBE"]
}

# Clonage et déploiement des machines virtuelles
resource "proxmox_vm_qemu" "vms" {
    count = length(var.vm_names)
    name        = var.vm_names[count.index]
    target_node = "pve"
    clone       = "TEMPLATE-DEB11"
    full_clone  = true

    # Autres paramètres de configuration de la VM...

    disk {
        size    = "50G"
        type    = "scsi"
        storage = "local-lvm"
    }
    boot    = "order=sata0"
    scsihw  = "virtio-scsi-single"
    memory  = "8192"
    cores   = 2
    network {
        model  = "virtio"
        bridge = "vmbr0"
    }
}

resource "null_resource" "ssh_target" {
    depends_on = [proxmox_vm_qemu.vms]
    connection {
        type        = "ssh"
        user        = "rponet"
        host        = "192.168.50.68"
        password    = "1234"
        #private_key = file("C:/Users/Maxime.ssh/id_rsa")
    }

    provisioner "remote-exec" {
        inline = [
            "sudo hostnamectl set-hostname SRV-MINIKUBE",
            "curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg",
            "echo 'deb [arch=amd64 signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable' | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null",
            "sudo apt-get update",
            "sudo apt-get install -y docker-ce docker-ce-cli containerd.io",
            "sudo systemctl start docker",
            "sudo systemctl enable docker",
            "sudo docker pull hello-world",
            "sudo docker run hello-world",
            "curl -Lo minikube https://storage.googleapis.com/minikube/releases/latest/minikube-linux-amd64",
            "chmod +x minikube",
            "sudo mv minikube /usr/local/bin/",
            "minikube version",
            "minikube start"
        ]
    }
}
