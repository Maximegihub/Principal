#pip install paramiko
import paramiko
import datetime

# Informations de connexion SSH
hostname = "adresse_ip_ou_nom_de_domaine"
port = 22
username = "votre_utilisateur_ssh"
password = "votre_mot_de_passe_ssh"

# Commande de sauvegarde à exécuter
backup_command = "commande_de_sauvegarde"

# Chemin où sauvegarder les fichiers
backup_directory = "/chemin/vers/dossier_de_sauvegarde/"

# Nom du fichier de sauvegarde
current_time = datetime.datetime.now().strftime("%Y%m%d%H%M%S")
backup_filename = f"backup_{current_time}.tar.gz"

# Connexion SSH
ssh_client = paramiko.SSHClient()
ssh_client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh_client.connect(hostname, port, username, password)

# Exécution de la commande de sauvegarde
stdin, stdout, stderr = ssh_client.exec_command(backup_command)

# Attendre que la commande soit terminée
stdout.channel.recv_exit_status()

# Téléchargement du fichier de sauvegarde
sftp = ssh_client.open_sftp()
sftp.get(f"{backup_directory}/{backup_filename}", backup_filename)
sftp.close()

# Fermeture de la connexion SSH
ssh_client.close()

print("Sauvegarde terminée avec succès!")