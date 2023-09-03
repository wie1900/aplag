<?php

namespace Aplag\Infra\ExcelExporter;

use Aplag\Domain\PortsOut\ExcelExporterInterface;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelExporter implements ExcelExporterInterface
{

    public function __construct()
    {
    }

    public function exportExcel(Request $request): string
    {
        // $arr = $request['edek'];
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        $a = $activeWorksheet;

        // column sizes
        $a->getColumnDimension('B')->setWidth(4);
        $activeWorksheet->getColumnDimension('C')->setWidth(65);
        $activeWorksheet->getColumnDimension('D')->setWidth(8);
        $activeWorksheet->getColumnDimension('E')->setWidth(65);
        $activeWorksheet->getColumnDimension('F')->setWidth(2);
        $activeWorksheet->getColumnDimension('G')->setWidth(31);
        $activeWorksheet->getColumnDimension('H')->setWidth(13);
        $activeWorksheet->getColumnDimension('I')->setWidth(12);

        // info-section
        $a->setCellValue('C2', 'Compare content of text A in text B');
        $a->setCellValue('C3', 'Anty-Plagiarism Checker');
        $a->getStyle('C3')->getFont()->setSize(14);
        $a->getStyle('C3')->getFont()->setBold(true);

        $a->setCellValue('C5', 'Checked Text (A)');
        $a->getStyle('C5')->getFont()->setSize(16);
        $a->getStyle('C5')->getFont()->setBold(true);
        $a->getStyle('C5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        $a->setCellValue('C6', 'Text'); // here Title of the document !
        $a->getStyle('C6')->getFont()->setBold(true);
        
        $a->setCellValue('E5', 'Possible Source Text (B)');
        $a->getStyle('E5')->getFont()->setSize(16);
        $a->getStyle('E5')->getFont()->setBold(true);
        $a->getStyle('E5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $a->setCellValue('E6', 'Source'); // here Title of the source !
        $a->getStyle('E6')->getFont()->setBold(true);
        
        $a->setCellValue('G2', 'Sentences in total:');
        $a->getStyle('G2')->getFont()->setBold(true);
        $a->setCellValue('G3', 'Sentences matched >50%:');
        $a->getStyle('G3')->getFont()->setColor(new Color(Color::COLOR_DARKGREEN ));
        $a->setCellValue('G4', 'Sentences matched 100%:');
        $a->getStyle('G4')->getFont()->setColor(new Color(Color::COLOR_RED ));
        $a->setCellValue('G5', 'Total length:');
        $a->getStyle('G5')->getFont()->setBold(true);
        $a->setCellValue('G6', 'Total matched length:');
        $a->getStyle('G6')->getFont()->setBold(true);
        $a->getStyle('G6')->getFont()->setColor(new Color(Color::COLOR_RED ));
        $a->setCellValue('G8', 'Found (A)Text in (B)Text:');
        $a->getStyle('G8')->getFont()->setSize(16);
        $a->getStyle('G8')->getFont()->setColor(new Color(Color::COLOR_RED ));
        $a->getStyle('G8')->getFont()->setBold(true);
        
        $a->setCellValue('H2', $request->segsCount);
        $a->getStyle('H2')->getFont()->setBold(true);
        $a->getStyle('H2')->getAlignment()->setIndent(1);
        $a->setCellValue('H3', $request->segMidCount);
        $a->getStyle('H3')->getFont()->setColor(new Color(Color::COLOR_DARKGREEN ));
        $a->getStyle('H3')->getAlignment()->setIndent(1);
        $a->getStyle('H3')->getFont()->setBold(true);
        $a->setCellValue('H4', $request->segHighCount);
        $a->getStyle('H4')->getFont()->setColor(new Color(Color::COLOR_RED ));
        $a->getStyle('H4')->getAlignment()->setIndent(1);
        $a->getStyle('H4')->getFont()->setBold(true);
        $a->setCellValue('H5', $request->totalLength);
        $a->getStyle('H5')->getAlignment()->setIndent(1);
        $a->getStyle('H5')->getFont()->setBold(true);
        $a->setCellValue('H6', $request->totalMatchedLength);
        $a->getStyle('H6')->getFont()->setColor(new Color(Color::COLOR_RED ));
        $a->getStyle('H6')->getAlignment()->setIndent(1);
        $a->getStyle('H6')->getFont()->setBold(true);
        $a->setCellValue('H8', $request->totalMatch/100);
        $a->getStyle('H8')->getFont()->setSize(16);
        $a->getStyle('H8')->getFont()->setColor(new Color(Color::COLOR_RED ));
        $a->getStyle('H8')->getAlignment()->setIndent(1);
        $a->getStyle('H8')->getNumberFormat()->setFormatCode('0.00%');
        $a->getStyle('H8')->getFont()->setBold(true);
        
        $a->setCellValue('I5', '('.$request->totalWordCount.' words)');
        $a->getStyle('I5')->getFont()->setBold(true);
        $a->getStyle('I5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $a->setCellValue('I6', '('.$request->matchedWordCount.' words)');
        $a->getStyle('I6')->getFont()->setColor(new Color(Color::COLOR_RED ));
        $a->getStyle('I6')->getFont()->setBold(true);
        $a->getStyle('I6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // sentences-section - header
        $a->setCellValue('B8', 'No');
        $a->getStyle('B8')->getFont()->setBold(true);
        $a->getStyle('B8')->getFill()->getStartColor()->setARGB('EEEEEEEE');
        $a->getStyle('B8')->getFill()->setFillType(Fill::FILL_SOLID);
        $a->getStyle('B8')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);

        $a->setCellValue('C8', '(A) Text Sentence');
        $a->getStyle('C8')->getFont()->setBold(true);
        $a->getStyle('C8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $a->getStyle('C8')->getFill()->getStartColor()->setARGB('EEEEEEEE');
        $a->getStyle('C8')->getFill()->setFillType(Fill::FILL_SOLID);
        $a->getStyle('C8')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
        

        $a->setCellValue('D8', 'Match');
        $a->getStyle('D8')->getFont()->setBold(true);
        $a->getStyle('D8')->getAlignment()->setIndent(1);
        $a->getStyle('D8')->getFill()->getStartColor()->setARGB('EEEEEEEE');
        $a->getStyle('D8')->getFill()->setFillType(Fill::FILL_SOLID);
        $a->getStyle('D8')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);

        $a->setCellValue('E8', '(B) Matched Source sentence');
        $a->getStyle('E8')->getFont()->setBold(true);
        $a->getStyle('E8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $a->getStyle('E8')->getFill()->getStartColor()->setARGB('EEEEEEEE');
        $a->getStyle('E8')->getFill()->setFillType(Fill::FILL_SOLID);
        $a->getStyle('E8')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
        
        // sentence-list
    
        // $a->getStyle('D'.$w)->getAlignment()->setIndent(1);
        $max = $request->segsCount+9;
        
        for($count=9;$count<$max;$count++){
            $idx = $count-9;
            
            // avoid excel cells break
            $text = str_replace("=","",$request->text[$idx]);
            $text_target = str_replace("=","",$request->match[$idx]);
            // -----------------------

            $a->setCellValue('B'.$count, $idx+1);
            $a->setCellValue('C'.$count, $text);
            $a->getStyle('C'.$count)->getAlignment()->setIndent(1);
            $a->getStyle('C'.$count)->getAlignment()->setWrapText(true);
            $a->getStyle('E'.$count)->getAlignment()->setWrapText(true);
            
            if($request->matchval[$idx] > 49){
                $a->setCellValue('D'.$count, $request->matchval[$idx]/100);
                $a->getStyle('D'.$count)->getNumberFormat()->setFormatCode('0%');
                $a->setCellValue('E'.$count, $text_target);
                $a->getStyle('E'.$count)->getAlignment()->setIndent(1);
                $a->getStyle('E'.$count)->getFont()->getColor()->setARGB('AAAAAAAA');
                $a->getStyle('D'.$count)->getAlignment()->setIndent(1);
                
                if($request->matchval[$idx] == 100){
                    $a->getStyle('C'.$count)->getFont()->setColor(new Color(Color::COLOR_RED ));
                    $a->getStyle('D'.$count)->getFont()->setColor(new Color(Color::COLOR_RED ));
                }else{
                    $a->getStyle('C'.$count)->getFont()->setColor(new Color(Color::COLOR_DARKGREEN ));
                    $a->getStyle('D'.$count)->getFont()->setColor(new Color(Color::COLOR_DARKGREEN ));
                }
            }else{
                $a->getStyle('C'.$count)->getFont()->getColor()->setARGB('AAAAAAAA');
            }
        }

        $a->setCellValue('E3', $request->name);
        $a->getStyle('E3');
        $writer = new Xlsx($spreadsheet);

        $replacer = [
            [",", "_"],
            ["/", "_"],
            ["\\", "_"],
            ["?", "_"],
            ["!", "_"],
            [".", "_"],
            ["`", "_"],
            ["~", "_"],
            ["@", "_"],
            ["#", "_"],
            ["$", "_"],
            ["%", "_"],
            ["^", "_"],
            ["&", "_"],
            ["*", "_"],
            ["'", "_"],
            [",", "_"],
            ["|", "_"],
            [" ", "_"]
        ];

        $forsave = $request->name;
        foreach ($replacer as $r) {
            $forsave = str_replace($r[0], $r[1], $forsave);
        }

        while (str_contains($forsave, "__")) {
            $forsave = str_replace("__", "_", $forsave);
        }

        $writer->save($path = storage_path($forsave.'.xlsx'));

        return $path;
    }

}
