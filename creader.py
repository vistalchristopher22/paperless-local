import pdfrw
import os
import argparse
import subprocess


def convert_docx_to_pdf(input_path, output_directory):
    command = ['C:\Program Files\LibreOffice\program\soffice.exe', '--headless', '--convert-to', 'pdf', '--outdir', output_directory, input_path]
    result = subprocess.run(command, stdout=subprocess.PIPE, stderr=subprocess.PIPE, shell=True)


def get_files_in_folder(folder_path):
    files = []
    for root, _, filenames in os.walk(folder_path):
        for filename in filenames:
            file_path = os.path.join(root, filename)
            if not file_path.lower().endswith('.pdf'):
                files.append(file_path)
    return files


parser = argparse.ArgumentParser(description='Transform attachment document to custom-attachment for URL Parser from a PDF file')
parser.add_argument('--directory', '-d', type=str, required=True, help='Directory')
args = parser.parse_args()

directory = args.directory
files = get_files_in_folder(directory)

MAIN_SOURCE = "C:/laragon/www/paperless/storage/app/public/committees"
for file in files:
    convert_docx_to_pdf(file, MAIN_SOURCE)
    new_path = MAIN_SOURCE + "/" + os.path.basename(file).replace('docx', 'pdf')
    pdf = pdfrw.PdfReader(new_path)
    new_pdf = pdfrw.PdfWriter()
    ATTACHMENT_MARK = "/custom-attachment/"
    for page in pdf.pages:
        for annot in page.Annots or []:
            current_url = annot.A.URI
            current_url = current_url[1:-1]
            new_url = ATTACHMENT_MARK + current_url
            new_url = pdfrw.objects.pdfstring.PdfString("(" + new_url + ")")
            annot.A.URI = new_url
        new_pdf.addpage(page)
    new_pdf.write(new_path)
