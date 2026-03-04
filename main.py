import subprocess, sys,sqlite3
from tabulate import tabulate
opts = {
    "1":"wmic OS get FreePhysicalMemory",
    "2":"type {parameter}",
    "3":"dir {parameter}",
    "4":"history",
    "5":"quit"

}
key = "YXNkOjIxMw=="
opts_key = {
    "1":"Check Available Free Memory",
    "2":"View a file",
    "3":"List a directory",
    "4":"View History",
    "5":"quit"

}
def insert_into_logbook(command):
    try:
        with sqlite3.connect('commander.db') as connection:
            # Create a cursor object
            cursor = connection.cursor()
            
            cursor.execute(f"INSERT INTO logs(payload) VALUES (\"{command}\")")

            connection.commit()
        return "Insertion Success"
    except Exception as e:
        return f"Insertion Failed: {e}"
def select_into_logbook(pattern):
    try:
        with sqlite3.connect('commander.db') as connection:
            # Create a cursor object
            cursor = connection.cursor()

            cursor.execute(f"SELECT * FROM logs WHERE payload LIKE '{pattern}'")
            results = []
            for log in cursor.fetchall():
                results.append(dict(zip(("id","log","timestamp"),log)))
            final = f"""{tabulate(results, headers="keys")}"""
            return final
    except Exception as e:
        raise Exception(e)
        return f"Failed to Select: {e}"        
    
def execute(option):
    # insecure
    try:
        arg_split = option.split(" ")
        print(insert_into_logbook(option))
        return f"""
        === OUTPUT ===
{subprocess.check_output(arg_split,shell=True,text=True).strip()}
        === END OUTPUT == 
        """
    except Exception as e:
        return "ERROR: Command Failed {err}".format(err=e)
    
def main():
    while True:
        print("""
    _   _   _   _   _   _   _   _  
    / \ / \ / \ / \ / \ / \ / \ / \ 
    ( C | o | m | m | & | a | n | t )
    \_/ \_/ \_/ \_/ \_/ \_/ \_/ \_/ 

    Your application for daily operating needs!
        """)
        name = input("What is your name?: ")
        exec(f"print('{name}')")
        print(f"""{"\n".join([str(key)+". "+str(opts_key[key]) for key in opts_key.keys()])}""")
        opt = input("Please type the number of one of these command: ")

        parsed_opt = opts.get(opt)

        if parsed_opt == "":
            continue
        if parsed_opt == "quit":
            print("Thank you!")
            sys.exit(0)
        if parsed_opt == "history":
            target = input("Do you want to search specific patterns? (enter to search all): ")
            if target == "":
                target = "%"
            print(select_into_logbook(target))
            continue
        if opt in ("2","3"):
            target = input("Please Input the designated File Or Directory: ")
            parsed_opt = parsed_opt.format(parameter=target)
        

        print(execute(parsed_opt))
        

if __name__ == "__main__":
    with sqlite3.connect('commander.db') as connection:
        # Create a cursor object
        cursor = connection.cursor()
        cursor.execute("CREATE TABLE IF NOT EXISTS logs (id INTEGER PRIMARY KEY, payload TEXT, time DATETIME DEFAULT CURRENT_TIMESTAMP)")
        connection.commit()
    
    main()
