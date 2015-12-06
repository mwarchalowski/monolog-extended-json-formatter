<?php
namespace Minimax\Monolog;
use \Monolog\Formatter\JsonFormatter;

/**
 * Extension to JsonFormatter to inject _SERVER and _REQUEST into context. 
 *
 * @author Maciej Warchalowski 
 */
class ExtendedJsonFormatter extends JsonFormatter
{
    protected function getCustomContext() {
        $context = $_SERVER;
        $context['REQUEST_PARAMETERS'] = $_REQUEST;
        return $context;
    }

    /**
     * {@inheritdoc}
     */
    public function format(array $record)
    {   
        $record['context'] = $this->getCustomContext(); 
        return json_encode($record) . ($this->appendNewline ? "\n" : '');
    }

    /**
     * Return a JSON-encoded array of records.
     *
     * @param  array  $records
     * @return string
     */
    protected function formatBatchJson(array $records)
    {   
        $record['context'] = array_merge($record['context'], $_SERVER); 
        return json_encode($records);
    }
}
