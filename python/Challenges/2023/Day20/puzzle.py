from collections import deque


class Puzzle:
    def first_part(self, input_string: str):
        modules = self.parse_modules(input_string)

        low_signal_count = 0
        high_signal_count = 0
        for i in range(1000):
            d = deque()
            d.append({
                'from': 'button',
                'to': 'broadcaster',
                'signal': 'low'
            })

            while d:
                signal = d.popleft()
                signal_type = signal['signal']
                to_name = signal['to']
                from_name = signal['from']

                if signal_type == 'high':
                    high_signal_count += 1
                else:
                    low_signal_count += 1

                if to_name not in modules:
                    continue

                to_module = modules[to_name]
                if to_module['type'] == 'broadcaster':
                    for connection in to_module['connections']:
                        d.append({
                            'from': 'broadcaster',
                            'to': connection,
                            'signal': signal_type
                        })

                if to_module['type'] == 'flipflop':
                    if signal_type == 'high':
                        continue
                    new_state = 1 if to_module['state'] == 0 else 0
                    modules[to_name]['state'] = new_state
                    for connection in to_module['connections']:
                        d.append({
                            'from': to_module['name'],
                            'to': connection,
                            'signal': 'low' if new_state == 0 else 'high'
                        })

                if to_module['type'] == 'conjunction':
                    to_module['inputs'][from_name] = signal_type
                    values = to_module['inputs'].values()
                    if all(value == list(values)[0] for value in values) and list(values)[0] == 'high':
                        signal_to_send = 'low'
                    else:
                        signal_to_send = 'high'

                    for connection in to_module['connections']:
                        d.append({
                            'from': to_module['name'],
                            'to': connection,
                            'signal': signal_to_send
                        })

        return low_signal_count * high_signal_count

    def parse_modules(self, input_string: str):
        rows = [a for a in input_string.split('\n')]
        modules = {}
        for row in rows:
            module, connections = row.split(' -> ')
            connections = connections.split(', ')

            if module == 'broadcaster':
                modules['broadcaster'] = {
                    'type': 'broadcaster',
                    'connections': connections,
                    'name': 'broadcaster'
                }
            if module[0] == '%':
                modules[module[1:]] = {
                    'type': 'flipflop',
                    'state': 0,
                    'connections': connections,
                    'name': module[1:]
                }
            if module[0] == '&':
                modules[module[1:]] = {
                    'type': 'conjunction',
                    'connections': connections,
                    'name': module[1:],
                    'inputs': {

                    }
                }
        for module in modules:
            name = modules[module]['name']
            connections = modules[module]['connections']
            for connection in connections:
                if connection not in modules:
                    continue
                if modules[connection]['type'] == 'conjunction':
                    modules[connection]['inputs'][name] = 'low'

        return modules

    def second_part(self, input_string: str):
        modules = self.parse_modules(input_string)

        rx_source = ""

        for module in modules:
            print(modules[module])
            if 'rx' in modules[module]['connections']:
                rx_source = modules[module]['name']

        print(rx_source)

        visited = {
            name: 0 for name, module in modules.items() if rx_source in module['connections']
        }

        print(visited)

        lengths = {}

        button_presses = 0
        while True:
            button_presses +=1
            print(button_presses,':', end='\r')
            d = deque()
            d.append({
                'from': 'button',
                'to': 'broadcaster',
                'signal': 'low'
            })

            while d:
                signal = d.popleft()
                signal_type = signal['signal']
                to_name = signal['to']
                from_name = signal['from']

                if to_name == rx_source and signal_type == 'high':
                    visited[from_name] = 1

                    if from_name not in lengths:
                        lengths[from_name] = button_presses

                    if all(visited.values()):
                        print(lengths)
                        product = 1
                        for length in lengths.values():
                            product *= length
                        print(product)
                        return product

                if to_name not in modules:
                    continue

                to_module = modules[to_name]
                if to_module['type'] == 'broadcaster':
                    for connection in to_module['connections']:
                        d.append({
                            'from': 'broadcaster',
                            'to': connection,
                            'signal': signal_type
                        })

                if to_module['type'] == 'flipflop':
                    if signal_type == 'high':
                        continue
                    new_state = 1 if to_module['state'] == 0 else 0
                    modules[to_name]['state'] = new_state
                    for connection in to_module['connections']:
                        d.append({
                            'from': to_module['name'],
                            'to': connection,
                            'signal': 'low' if new_state == 0 else 'high'
                        })

                if to_module['type'] == 'conjunction':
                    to_module['inputs'][from_name] = signal_type
                    values = to_module['inputs'].values()
                    if all(value == list(values)[0] for value in values) and list(values)[0] == 'high':
                        signal_to_send = 'low'
                    else:
                        signal_to_send = 'high'

                    for connection in to_module['connections']:
                        d.append({
                            'from': to_module['name'],
                            'to': connection,
                            'signal': signal_to_send
                        })

        return 0


# 800310899 too low