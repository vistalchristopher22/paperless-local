import os
import subprocess
import sys

# python explorer.py C:\laragon\www\paperless\artisan

if len(sys.argv) < 2:
    print('Usage: python explorer.py <file_path>')
    sys.exit()

file_path = sys.argv[1]
file_path = os.path.normpath(file_path)
subprocess.Popen(['explorer', '/select,', file_path], shell=True)