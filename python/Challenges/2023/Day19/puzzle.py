import re


class Puzzle:
    def first_part(self, input_string: str):
        workflows, parts = input_string.split('\n\n')

        pattern = re.compile(r'(?P<name>[^{\n]+){(?P<instructions>[^}]+)}')
        instruction_pattern = re.compile(
            r'(?P<name>[a-zA-Z])\s*(?P<sign>[<>])\s*(?P<numbers>\d+):(?P<result>[a-zA-Z]*)')

        nodes = {}
        for workflow in workflows.split('\n'):
            match = pattern.match(workflow).groupdict()
            name = match['name']
            instructions = match['instructions'].split(',')

            nodes[name] = {}

            last = instructions.pop(-1)
            nodes[name]['last'] = last
            instructions_lambdas = []
            for instruction in instructions:
                match = instruction_pattern.match(instruction).groupdict()
                result = match['result']

                instructions_lambdas.append(match)

            nodes[name]['lambdas'] = instructions_lambdas

        def evaluate(x, m, a, s, work):
            value = locals()[work['name']]
            sign = work['sign']
            number = int(work['numbers'])

            return work['result'] if (value > number and sign == '>') or (value < number and sign == '<') else None

        suma = 0
        for part in parts.split('\n'):
            pattern = r'(\w+)=(\d+)'

            matches = re.findall(pattern, part)

            variable_dict = {key: int(value) for key, value in matches}

            current_node = nodes['in']

            while True:
                for func in current_node['lambdas']:
                    result = evaluate(variable_dict['x'],variable_dict['m'],variable_dict['a'],variable_dict['s'],func)
                    if result is None:
                        continue
                    else:
                        break
                if result is None:
                    result = current_node['last']
                if result == 'A':
                    suma += (variable_dict['x'] + variable_dict['m'] + variable_dict['a'] + variable_dict['s'])
                    break
                if result == 'R':
                    break
                current_node = nodes[result]

        return suma

    def second_part(self, input_string: str):
       return 0
