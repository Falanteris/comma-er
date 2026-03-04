import subprocess, sys

opts = {
    "1":"wmic OS get FreePhysicalMemory",
    "2":"type {parameter}",
    "3":"dir {parameter}",
    "4":"quit"

}

opts_key = {
    "1":"Check Available Free Memory",
    "2":"View a file",
    "3":"List a directory",
    "4":"quit"

}
def execute(option):
    # insecure
    try:
        arg_split = option.split(" ")
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
        print(f"""{"\n".join([str(key)+". "+str(opts_key[key]) for key in opts_key.keys()])}""")
        opt = input("Please type the number of one of these command: ")

        parsed_opt = opts.get(opt)

        if parsed_opt == "":
            continue
        if parsed_opt == "quit":
            print("Thank you!")
            sys.exit(0)
        if opt in ("2","3"):
            target = input("Please Input the designated File Or Directory: ")
            parsed_opt = parsed_opt.format(parameter=target)
        

        print(execute(parsed_opt))
        

if __name__ == "__main__":
    main()
