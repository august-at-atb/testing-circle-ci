<?php

namespace App\Http\Controllers;
use App\Models\Buzz\Entities\Buzz;
use Illuminate\Support\Debug\Dumper;

class ExampleController extends Controller {
    protected $buzzEntity;

    protected $dumper;

    public function __construct(Buzz $buzzEntity, Dumper $dumper){
        $this->buzzEntity = $buzzEntity;
        $this->dumper = $dumper;
    }

    public function index(){
        $this->dumper->dump('Hello, how are you?');
        $this->dumper->dump('Checking that Doctrine Entity creation...');

        $this->buzzEntity->fillFromArray([
                'foo' => 'somefoo',
                'bar' => 'somebar',
                'num' => 123
        ]);
        $this->buzzEntity->save();
        $this->dumper->dump('Created!');

        $this->dumper->dump('Checking that Doctrine Entity lookup...');
        $buzzRepo = $this->buzzEntity->getRepository();
        $found = $buzzRepo->findOneBy(['bar' => 'somefoo']);
        $this->dumper->dump($found);

        $this->dumper->dump('Operations with collection now...');
        $buzzRepo = $this->buzzEntity->getRepository();

        foreach ($buzzRepo->findAll() as $buzzItem){
            $this->dumper->dump($buzzItem);
        }
        $this->dumper->dump('Completed health check!');

    }
}
