import sys
import re

file_path = 'ca/lib/screens/booking_module/add_booking_forms/grooming_service_screen.dart'
with open(file_path, 'r', encoding='utf-8') as f:
    lines = f.readlines()

idx_select_branch = next(i for i, line in enumerate(lines) if '\"Select Branch\"' in line)
idx_branch_start = idx_select_branch
while 'Container(' not in lines[idx_branch_start]:
    idx_branch_start -= 1
idx_branch_start -= 1 # to include 16.height

idx_date_time = next(i for i, line in enumerate(lines) if '\"Date & Time\"' in line)
idx_date_start = idx_date_time
while 'Container(' not in lines[idx_date_start]:
    idx_date_start -= 1
idx_date_start -= 1 # to include 16.height

idx_service_details = next(i for i, line in enumerate(lines) if '\"Service Details\"' in line)
idx_service_start = idx_service_details
while 'Container(' not in lines[idx_service_start]:
    idx_service_start -= 1
idx_service_start -= 1 # to include 16.height

idx_add_info = next(i for i, line in enumerate(lines) if '\"Additional Info\"' in line)
idx_add_info_start = idx_add_info
while 'Container(' not in lines[idx_add_info_start]:
    idx_add_info_start -= 1
idx_add_info_start -= 1

print(f'Branch start: {idx_branch_start}')
print(f'Date start: {idx_date_start}')
print(f'Service start: {idx_service_start}')
print(f'Additional Info start: {idx_add_info_start}')

part1 = lines[:idx_branch_start]
part2_branch_date = lines[idx_branch_start:idx_service_start]
part3_service = lines[idx_service_start:idx_add_info_start]
part4_rest = lines[idx_add_info_start:]

new_lines = part1 + part3_service + part2_branch_date + part4_rest
with open(file_path, 'w', encoding='utf-8') as f:
    f.writelines(new_lines)
print('Done!')
