<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Http\Request;

class ApiRepository
{

    private $model;
    protected $logDatabase = false;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function all()
    {
        try {
            return $this->model->all();
        } catch (Exception $e) {
            return $e;
        }
    }

    public function store(Request $request)
    {
        try {
            if ($this->logDatabase) {
                DB::enableQueryLog();
            }

            $data = $request->all();

            $new = [];
            foreach ($data as $key => $value) {
                $new[$key] = $value;
            }

            $model = $this->model->create($new);

            if ($this->logDatabase) {
                $this::createLog(get_class($this), DB::getQueryLog(), $model['id']);
            }

            return json_encode($data);
        } catch(Exception $e) {
            return $e;
        }
    }

    public function show($id)
    {
        try {
            $data = $this->model::find($id);

            if (isset($data)) {
                return json_encode($data);
            }
            return response('Marca não encontrada', 404);
        } catch(Exception $e) {
            return $e;
        }
    }

    public function update($request, $id)
    {
        try {
            $model = $this->model::find($id);

            if (!$model) {
                return response()->json(['error' => 'Registro não encontrado'], 200);
            }

            if ($this->logDatabase) {
                DB::enableQueryLog();
            }

            $data = $request->all();

            foreach ($data as $key => $value) {
                $new[$key] = $value;
            }

            $model = $this->model->where('id', $id)
                ->update($new);

            if ($this->logDatabase) {
                $this::createLog(get_class($this), DB::getQueryLog(), $id);
            }

            return json_encode($model);
        } catch(Exception $e) {
            return $e;
        }
    }
    
    public function destroy($id)
    {
        try {
            $model = $this->model::find($id);
            if (!$model) {
                return response()->json(['error' => 'Registro não encontrado'], 200);
            }

            if ($this->logDatabase) {
                DB::enableQueryLog();
            }

            $model->delete();

            if ($this->logDatabase) {
                $this::createLog(get_class($this), DB::getQueryLog(), $id);
            }

            return json_encode($model);
        } catch (Exception $e) {
            return $e;
        }
    }

    public static function createLog($class, $logs, $id, $process = null)
    {
        DB::disableQueryLog();
        $user = auth()->user()->id ?? 0;
        $class = str_replace('App\\Repository\\', '', $class);

        foreach ($logs as $log) {
            DB::table('log_databases')->insert([
                'class' => $class,
                'action' => strtoupper(substr($log['query'], 0, 1)),
                'sql' => $log['query'],
                'bindings' => json_encode($log['bindings']),
                'time' => $log['time'],
                'user_id' => $user,
                'class_id' => $id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
