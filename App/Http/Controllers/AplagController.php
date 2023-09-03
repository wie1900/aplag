<?php

namespace Aplag\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Aplag\App\Http\Requests\TwoTextesRequest;
use Aplag\Domain\PortsIn\CompServiceInterface;

class AplagController extends Controller
{
    public function __construct(
        public CompServiceInterface $compServiceInterface
    ) {}
    
    public function index()
    {
        return view('aplag::start',[
            "title"=>"AntyPlagiarism Checker"
        ]);
    }

    public function compared(TwoTextesRequest $request)
    {

        $compText = $this->compServiceInterface->getCompText(
            $request->text1,
            $request->text2
        );
        $report = $this->compServiceInterface->getReport($compText);

        return view('aplag::posted', [
            "tekst"=>$compText,
            "report"=>$report,
            "name"=>$request->name,
            "title"=>"AntyPlagiarism Checker - Results"
        ]);
    }
}
