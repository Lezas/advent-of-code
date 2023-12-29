from math import prod;
from igraph import Graph

class Puzzle:
    def first_part(self, input_string: str):
        # chatgpt ftw...
        G = {v: e.split() for v, e in [l.split(':') for l in input_string.split('\n')]}
        result = prod(Graph.ListDict(G).mincut().sizes())

        return result

    def second_part(self, input_string: str):
        return 0
