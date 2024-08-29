import asyncio


class GlobalStore:
    def __init__(self):
        self._store = {}

    def get(self, key, default=None):
        return self._store.get(key, default)

    def set(self, key, value):
        self._store[key] = value
        return value

    def delete(self, key):
        del self._store[key]

    def keys(self):
        return list(self._store.keys())

    def values(self):
        return list(self._store.values())

    def items(self):
        return list(self._store.items())

    def clear(self):
        self._store.clear()

    def __len__(self):
        return len(self._store)

    def __contains__(self, key):
        return key in self._store

    def __getitem__(self, key):
        return self._store[key]

    def __setitem__(self, key, value):
        self._store[key] = value

    def __delitem__(self, key):
        del self._store[key]

    def __iter__(self):
        return iter(self._store)


global_store = GlobalStore()
