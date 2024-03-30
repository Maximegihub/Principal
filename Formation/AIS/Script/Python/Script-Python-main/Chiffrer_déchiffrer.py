from hashlib import sha256

entree = input("Entrer le nom du fichier à chiffrer ou déchiffrer : ")
sortie = input("Entrer le nom du fichier final : ")
key = input("Entrer la clé : ")
keys = sha256(key.encode('utf-8')).digest()

with open(entree, 'rb') as f_entree:
    with open(sortie, 'wb') as f_sortie:
        i = 0
        while True:
            c = f_entree.read(1)
            if not c:
                break
            j = i % len(keys)
            b = bytes([c[0] ^ keys[j]])
            f_sortie.write(b)
            i += 1
