
import os
import subprocess
import sys
# python explorer.py "C:/laragon/www/paperless/storage/app/source/BOARD_SESSIONS/1693506050_OB_25TH___REGULAR_SESSION__JANUARY_10,_2023_TANDAG_CITY.docx"

# Check if a file path is provided as a command-line argument
if len(sys.argv) < 2:
    print('Usage: python explorer.py <file_path>')
    sys.exit()

# Get the file path from the command-line argument
file_path = sys.argv[1]
file_path = os.path.normpath(file_path)

# Open the file in the Windows File Explorer
subprocess.Popen(f'explorer /select,"{file_path}"')