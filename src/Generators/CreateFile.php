<?php

namespace GrupoCometa\Validations\Generators;


class CreateFile
{
    public function __construct(private Validations $validations, private $namespace, private $className)
    {
    }

    private function template()
    {
        $template = '<?php' . PHP_EOL;
        $template .= file_get_contents(__DIR__ . '/template');
        $bindings = [
            '{{namespace}}' => $this->namespace,
            '{{className}}' => ucfirst($this->className),
            '{{validations}}' => (string) $this->validations
        ];

        $template = str_replace(array_keys($bindings), array_values($bindings), $template);
        return $template;
    }

    public function save()
    {
        $folder = $this->createFolder();
        $filename = $folder . "/" . $this->className . ".php";

        file_put_contents($filename, $this->template());
    }

    private function createFolder()
    {
        $folder = base_path(lcfirst($this->namespace));
        $folder =  str_replace('\\', '/', $folder);
        $folder = $this->snakeCaseToPascalCase($folder);
        if (file_exists($folder)) return $folder;

        mkdir($folder);
        return $folder;
    }

    private function snakeCaseToPascalCase($str)
    {
        $str = ucwords($str, '_');
        $str = str_replace('_', '', $str);
        return $str;
    }
}
