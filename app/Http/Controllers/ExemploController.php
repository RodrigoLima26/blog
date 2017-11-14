<?php

namespace App\Http\Controllers;

use Excel;

use App\Model\Institute;
use App\Model\State;
use App\Transformers\InstituteXLSTransformer;

use Illuminate\Http\Request;

use Auth;

/**
 * @package App\Http\Controller
 * @author Daniel Bonatti
 */
class ExemploController extends Controller {

    protected $xlsValidations = [];

	/**
     * Display a listing of the resource.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        dd(Participant::id());

        // get data
        $institutes = Institute::q($request->q)->
                                 orderBy('name')->
                                 paginate(50);

        // return view
        return view('master.institutes.index', compact('institutes'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $institute = new Institute;
        $states = State::orderBy('abbr')->get();

        return view('master.institutes.show', compact('institute', 'states'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        // validate
        $v = Institute::validate($request->all());

        if ($v->fails()) {
            return redirect()->back()->
                   withInput($request->all())->
                   withErrors($v);
        }

        try {

            // store, get dirty or new
            $institute = $request->id ? Institute::find($request->id) : new Institute;
            $institute->store($request->all());

            // return to form
            if (!$request['_go']) {
                return redirect("/master/instituicoes/{$institute->id}")->
                       with(['flash_message' => 'Instituição salva com sucesso!', 'flash_message_level' => 'success']);
            }

            return  redirect("/master/instituicoes/")->
                    with(['flash_message' => 'Instituição salva com sucesso!', 'flash_message_level' => 'success']);
        }

        catch (\Exception $e) {

            // logging and return 
            \Log::error("Error storing App\Model\Institute - {$e->getMessage()} in {$e->getFile()} line {$e->getLine()}");

            return redirect()->back()->
                   withInput($request->all())->
                   with(['flash_message' => 'Erro ao salvar Instituição :(', 'flash_message_level' => 'error']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Institute $institute
     * @return \Illuminate\Http\Response
     */
    public function show(Institute $institute) {

        $states = State::orderBy('abbr')->get();

        return view('master.institutes.show', compact('institute', 'states'));

    }


    /**
     * @param Institute $institute
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Institute $institute, Request $request) {

        try {

            $institute->delete();

            if (!$request['_go']) {
                return redirect()->back()->
                       with(['flash_message' => 'Instituição excluída com sucesso!', 'flash_message_level' => 'warning']);
            }

            else {
                return redirect('/master/instituicoes')->
                       with(['flash_message' => 'Instituição excluída com sucesso!', 'flash_message_level' => 'warning']);
            }
        }

        catch (\Exception $e) {

            // logging and return 
            \Log::error("Error destroying App\Model\Institute - {$e->getMessage()} in {$e->getFile()} line {$e->getLine()}");

            return redirect()->back()->
                   with(['flash_message' => 'Erro ao excluir Instituição :(', 'flash_message_level' => 'error']);

        }

    }


    /**
     * show form for upload XLS file
     * 
     * @param Request $request 
     * @return \Illuminate\Http\Response
     */
    public function formXLSFile(Request $request) {
        
        return view('master.institutes.show-import');

    }

    /**
     * import XLS file to Database
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function importXLSFile(Request $request) {

        try {

            Excel::load($request->file, function($reader) {

                // get rows
                $validation = [];
                $results = $reader->first();

                foreach ($results as $row) {

                    // transform
                    $data = InstituteXLSTransformer::transform($row);

                    // validate
                    $v = Institute::validate($data);

                    if (!$v->fails()) {

                        // search for Institute
                        $institute = Institute::qNameOrCnpj($row->nome, $row->cnpj)->first();

                        // new
                        if (!$institute)
                            $institute = new Institute;

                        // set data
                        $institute->store($data);
                    }

                    else {
                        // not valid
                        array_push($validation, ['row' => $row, 'validation' => $v->errors()->all()]);
                    }
                    
                }

                // return
                $this->xlsValidations = $validation;

            });

            // verifica se ha validacoes
            if (!$this->xlsValidations) {
                return redirect()->back()->
                       with(['flash_message' => 'Instituições importados com sucesso!', 'flash_message_level' => 'success', 
                             'validation' => $this->xlsValidations]);
            }

            return redirect()->back()->
                       with(['flash_message' => 'Instituições importados com sucesso, porém com validações!', 'flash_message_level' => 'warning', 
                             'validation' => $this->xlsValidations]);
        }

        catch (\Exception $e) {

            // logging and return 
            \Log::error("Error importing XLS for App\Model\Institute - {$e->getMessage()} in {$e->getFile()} line {$e->getLine()}");

            return redirect()->back()->
                   with(['flash_message' => 'Erro ao importar arquivo. Entre em contato conosco!', 'flash_message_level' => 'error']);

        }

    }

    /**
     * Description
     * @param Request $request 
     * @return \Illuminate\Http\Response
     */
    public function downloadXLSFileModel(Request $request) {
        
        return response()->download(public_path("master/models-xls/modelo_importacao_instituicao.xlsx"));

    }

}