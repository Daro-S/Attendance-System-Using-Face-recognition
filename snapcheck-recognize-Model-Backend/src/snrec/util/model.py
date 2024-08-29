from pathlib import Path
import re
from src.snrec.global_store import global_store

model_base_path = Path("model")
transfer_model_pattern = r"transfer-model-.+-(\d+).h5"


def load_transferred_model():
    times: dict[int, Path] = {}
    for model_path in model_base_path.iterdir():
        if model_path.name.endswith(".h5"):
            result = re.match(transfer_model_pattern, model_path.name)
            if result:
                times[int(result.group(1))] = model_path
    if not times:
        return None

    latest_time = max(times.keys())
    print(f"Loading model from {times[latest_time]}")
    return global_store.set("nn_model_path", times[latest_time])
