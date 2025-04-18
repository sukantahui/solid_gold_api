<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;  // Add this import
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
use App\Exceptions\DatabaseOperationException;
use App\Exceptions\DatabaseConnectionException;
use Illuminate\Validation\ValidationException;
use Exception;
use PDOException;

trait HandlesTransactions {
    public function executeInTransaction(callable $callback, array $context = [])
    {
        DB::beginTransaction();
        
        try {
            $result = $callback();
            DB::commit();
            
            Log::debug('Transaction completed successfully', array_merge([
                'execution_time' => microtime(true) - LARAVEL_START,
                'memory_usage' => memory_get_usage(true) / 1024 / 1024 . ' MB'
            ], $context));
            
            return $result;
            
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Log::error('Related model not found', [
                'error' => $e->getMessage(),
                'model' => $e->getModel(),
                'context' => $context
            ]);
            throw $e;
            
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error('Database operation failed', [
                'error' => $e->getMessage(),
                'sql' => Str::limit($e->getSql(), 200),
                'context' => $context
            ]);
            throw new DatabaseOperationException($e);
            
        } catch (PDOException $e) {
            DB::rollBack();
            Log::critical('Database connection problem', [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'context' => $context
            ]);
            throw new DatabaseConnectionException($e);
            
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::warning('Validation failed', [
                'errors' => $e->errors(),
                'context' => $context
            ]);
            throw $e;
            
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Transaction failed', [
                'error' => $e->getMessage(),
                'exception' => get_class($e),
                'context' => $context,
                'trace' => Str::limit($e->getTraceAsString(), 200)
            ]);
            throw $e;
        }
    }
}