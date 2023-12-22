import re


class Puzzle:
    def first_part(self, input_string: str):
        workflows, parts = input_string.split('\n\n')

        pattern = re.compile(r'(?P<name>[^{\n]+){(?P<rules>[^}]+)}')
        rules_pattern = re.compile(r'(?P<name>[a-zA-Z])\s*(?P<sign>[<>])\s*(?P<numbers>\d+):(?P<result>[a-zA-Z]*)')

        nodes = {}
        for workflow in workflows.split('\n'):
            match = pattern.match(workflow).groupdict()
            name = match['name']
            rules = match['rules'].split(',')

            nodes[name] = {
                'last': rules.pop(-1),
                'rules': [rules_pattern.match(rule).groupdict() for rule in rules]
            }

        def evaluate(x, m, a, s, rule):
            value = locals()[rule['name']]
            sign = rule['sign']
            number = int(rule['numbers'])

            return rule['result'] if (value > number and sign == '>') or (value < number and sign == '<') else None

        suma = 0
        for part in parts.split('\n'):
            pattern = r'(\w+)=(\d+)'
            matches = re.findall(pattern, part)
            variables = {key: int(value) for key, value in matches}
            current_node = nodes['in']

            while True:
                for rule in current_node['rules']:
                    result = evaluate(variables['x'], variables['m'], variables['a'], variables['s'], rule)
                    if result is None:
                        continue
                    else:
                        break
                if result is None:
                    result = current_node['last']
                if result == 'A':
                    suma += (variables['x'] + variables['m'] + variables['a'] + variables['s'])
                    break
                if result == 'R':
                    break
                current_node = nodes[result]

        return suma

    def second_part(self, input_string: str):
        workflows, parts = input_string.split('\n\n')

        pattern = re.compile(r'(?P<name>[^{\n]+){(?P<rules>[^}]+)}')
        rules_pattern = re.compile(r'(?P<name>[a-zA-Z])\s*(?P<sign>[<>])\s*(?P<numbers>\d+):(?P<result>[a-zA-Z]*)')

        nodes = {}
        for workflow in workflows.split('\n'):
            match = pattern.match(workflow).groupdict()
            name = match['name']
            rules = match['rules'].split(',')

            nodes[name] = {}
            nodes[name]['last'] = rules.pop(-1)
            nodes[name]['rules'] = (rules_pattern.match(rule).groupdict() for rule in rules)

        return count_ranges({
            'x': (1, 4000),
            'm': (1, 4000),
            'a': (1, 4000),
            's': (1, 4000),
        }, 'in', nodes)


def count_ranges(ranges, current_node_name, nodes):
    if current_node_name == 'R':
        return 0

    if current_node_name == 'A':
        product = 1
        for variable_name, (start, end) in ranges.items():
            product *= end - start + 1
        return product

    suma = 0
    current_node = nodes[current_node_name]

    loading_ranges = ranges.copy()

    for rule in current_node['rules']:
        sign = rule['sign']
        variable_name = rule['name']
        assert_number = int(rule['numbers'])
        result = rule['result']

        asserted_range = loading_ranges[variable_name]

        if sign == '<':
            if assert_number < asserted_range[0]:
                continue
            if asserted_range[1] < assert_number:
                new_range = loading_ranges.copy()
                suma += count_ranges(new_range, result, nodes)
                return suma

            new_range = loading_ranges.copy()
            new_range[variable_name] = (asserted_range[0], assert_number - 1)

            suma += count_ranges(new_range, result, nodes)
            loading_ranges[variable_name] = (assert_number, asserted_range[1])
        if sign == '>':
            if asserted_range[1] < assert_number:
                continue
            if asserted_range[0] > assert_number:
                new_range = loading_ranges.copy()

                suma += count_ranges(new_range, result, nodes)
                return suma

            new_range = loading_ranges.copy()
            new_range[variable_name] = (assert_number + 1, asserted_range[1])

            suma += count_ranges(new_range, result, nodes)
            loading_ranges[variable_name] = (asserted_range[0], assert_number)

    suma += count_ranges(loading_ranges, current_node['last'], nodes)
    return suma
