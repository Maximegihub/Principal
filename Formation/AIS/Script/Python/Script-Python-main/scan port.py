import socket 

ip = "127.0.0.1"
ports_list = [80,443,22,3389]

for port in ports_list:
    s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    result = s.connect_ex(("127.0.0.1", port))
    if result == 0:
        print (f"{port} : open")
    else :
        print (f"{port} : close")
    s.close()
    
