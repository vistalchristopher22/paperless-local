import pdfrw
import os
import argparse

parser = argparse.ArgumentParser(description='Transform attachment documenet to custom-attachment for URL Parser from a PDF file')
parser.add_argument('--file', '-f', type=str, required=True, help='PDF file path')
# Parse command line arguments
args = parser.parse_args()

filename = os.path.basename(args.file)
directory = os.path.dirname(args.file)

pdf = pdfrw.PdfReader(args.file)
new_pdf = pdfrw.PdfWriter()
MAIN_URL_SOURCE = "../../../laragon/www/paperless/storage/app/source/"
CUT_WORD = "paperless"
PREFIX_ATTACHMENT = "/custom-attachment/"
for page in pdf.pages:
    for annot in page.Annots or []:

        current_url = annot.A.URI
        current_url = current_url[1:-1]
        if "paperless" and "source" not in current_url:
            current_url = MAIN_URL_SOURCE + current_url

        new_url =  PREFIX_ATTACHMENT + '/'.join(current_url.split("/")[current_url.split("/").index(CUT_WORD)+1:])
        new_url = pdfrw.objects.pdfstring.PdfString("(" + new_url + ")")
        annot.A.URI = new_url

    new_pdf.addpage(page)

new_pdf.write(directory + "/" + filename)
