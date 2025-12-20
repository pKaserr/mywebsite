import subprocess
from pathlib import Path

delete_update_file_path = Path("update_files_on_server.txt")
delte_delete_file_path = Path("delete_on_server.txt")

staged = subprocess.check_output(
    ["git", "diff", "--name-only", "--cached"], text=True).splitlines()

current_in_update_file = set(delete_update_file_path.read_text().splitlines()) if delete_update_file_path.exists() else set()
updated_list = current_in_update_file.union(staged)
delete_update_file_path.write_text("\n".join(sorted(updated_list)) + "\n")

deleted_files = {f for f in current_in_update_file if not Path(f).exists()}
clean_list = updated_list - deleted_files

delete_update_file_path.write_text("\n".join(sorted(clean_list)) + "\n")
delte_delete_file_path.write_text("\n".join(sorted(deleted_files)) + "\n")
