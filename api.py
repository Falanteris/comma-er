from flask import Flask, request, jsonify
import subprocess
app = Flask(__name__)

@app.route("/echo", methods=["GET", "POST"])
def echo():
    if request.method == "POST":
        data = request.get_json(silent=True) or {}
        user_input = data.get("input", "")
    else:
        user_input = request.args.get("input", "")
    
    parsed = user_input
    
    valid_commands = {
        "whoami":"whoami",
    }
    cleaned = valid_commands.get(parsed)
    print(cleaned)
    if  cleaned:
        return jsonify({"echo": subprocess.check_output(cleaned,text=True)})
    else:
        return jsonify({"echo":"Invalid command"})
if __name__ == "__main__":
    app.run(debug=False)