<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExcelExport extends DefaultValueBinder implements FromCollection, ShouldAutoSize, WithHeadings, WithStyles, WithCustomValueBinder
{

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->data->values()->map(function ($item, $index) {
            $row = $item->toArray();
            // Sisipkan 'nomer' di awal
            return array_merge(['no' => $index + 1], $row);
        });
    }

    public function headings(): array
    {
        $header = [];

        $firstRow = $this->collection()[0] ?? [];

        foreach (array_keys($firstRow) as $key) {
            $header[] = strtoupper(str_replace('_', ' ', $key));
        }

        return $header;
    }

    public function styles(Worksheet $sheet)
    {
        $styles = [
            1 => ['font' => ['bold' => true]],
        ];

        return $styles;
    }

    public function bindValue(Cell $cell, $value)
    {
        $stringColumn = ["E", "F", "I"];
        if (in_array($cell->getColumn(), $stringColumn)) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);
            return true;
        }

        return parent::bindValue($cell, $value);
    }
}
