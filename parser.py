import docx
import pathlib
import os
from urllib.parse import unquote
import json
import argparse

parser = argparse.ArgumentParser(description='Get attachments of the file')
parser.add_argument('--file', '-f', type=str, required=True, help='File')
# Parse command line arguments
args = parser.parse_args()

base_path = "C:\\laragon\\www\\paperless\\storage\\app\\source\\"

def search_files(file, cache={}, root=None, subroot=None, level=0):
    file_path = pathlib.Path(file)
    if not file_path.is_absolute():
        # If the file path is not absolute, assume it is relative to the current working directory
        file_path = pathlib.Path.cwd() / file_path
    else:
        # If the file path is absolute, use it as is
        file_path = file_path.resolve()

    # Check if the file has already been searched and return the cached attachments
    if file_path in cache:
        return cache[file_path]

    doc = docx.Document(file_path)
    attachments = []

    for element in doc.element.iter():
        if element.tag.endswith('hyperlink'):
            hyperlink_id = element.attrib['{http://schemas.openxmlformats.org/officeDocument/2006/relationships}id']
            relationship = doc.part.rels[hyperlink_id]
            hyperlink_uri = relationship.target_ref
            for attachment_path in pathlib.Path(base_path).rglob(os.path.basename(unquote(hyperlink_uri))):
                attachments.append(str(attachment_path))

    # Recursively search for attachments in child files
    child_attachments = []
    for attachment in attachments:
        child_attachments.append(search_files(attachment, cache=cache, root=file_path, subroot=subroot, level=level+1))

    # Add the file and its attachments to the cache
    cache[file_path] = {"file_name": file_path.name, "file_path": str(file_path), "level": level, "attachments": child_attachments} if child_attachments else {"file_name": file_path.name, "file_path": str(file_path), "level": level, "attachments": []}

    # Return a dictionary with custom keys
    return {"file_name": file_path.name, "file_path": str(file_path), "level": level, "attachments": child_attachments}

top_level_attachments = search_files(args.file, cache={})
json_result = json.dumps(top_level_attachments, indent=2)
print(json_result)
