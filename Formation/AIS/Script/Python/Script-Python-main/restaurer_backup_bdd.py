import paramiko

# Informations de connexion SSH
hostname = "adresse_ip_ou_nom_de_domaine"
port = 22
username = "votre_utilisateur_ssh"
password = "votre_mot_de_passe_ssh"

# Chemin du fichier de sauvegarde à restaurer
backup_filename = "backup_YYYYMMDDHHMMSS.tar.gz"

# Commande de restauration à exécuter
restore_command = f"commande_de_restauration {backup_filename}"

# Connexion SSH
ssh_client = paramiko.SSHClient()
ssh_client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh_client.connect(hostname, port, username, password)

# Copie du fichier de sauvegarde sur le serveur distant
sftp = ssh_client.open_sftp()
sftp.put(backup_filename, backup_filename)
sftp.close()

# Exécution de la commande de restauration
stdin, stdout, stderr = ssh_client.exec_command(restore_command)

# Attendre que la commande soit terminée
stdout.channel.recv_exit_status()

# Suppression du fichier de sauvegarde sur le serveur distant
ssh_client.exec_command(f"rm {backup_filename}")

# Fermeture de la connexion SSH
ssh_client.close()

print("Restauration terminée avec succès!")
