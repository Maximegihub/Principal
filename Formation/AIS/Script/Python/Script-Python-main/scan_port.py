import socket 

ip = "127.0.0.1"
ports_list = [80,443,22,3389]

for port in ports_list:
    try:
        s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        result = s.connect_ex(("172.16.10.1", port))
        if result == 0:
            print (f"{port} : open")
        else :
            print (f"{port} : close")
    except Exception as err:
        print (f"error : {err}")
    finally:    
        s.close()