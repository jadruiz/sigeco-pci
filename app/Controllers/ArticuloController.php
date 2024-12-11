<?php

namespace App\Controllers;

use App\Models\ArticuloModel;
use CodeIgniter\RESTful\ResourceController;

class ArticuloController extends ResourceController
{
    protected $articuloModel;

    public function __construct()
    {
        $this->articuloModel = new ArticuloModel();
        helper(['form', 'url']);
    }

    public function subir($congreso_id)
    {
        $congresoModel = new \App\Models\CongresoModel();
        $congreso = $congresoModel->find($congreso_id);
        if (!$congreso) {
            return redirect()->to('/dashboard')->with('error', 'Congreso no encontrado.');
        }
        $data = [
            'congreso' => $congreso,
            'formatos_permitidos' => ['PDF', 'LaTeX (.zip o .tar)'],
            'peso_maximo' => '10MB',
        ];
        return view('website/congresos/articulos/subir', $data);
    }

    public function descargar($id)
    {
        $userId = session()->get('wlp_id'); // Verificar usuario autenticado
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Debe iniciar sesión.');
        }

        // Buscar el archivo en la base de datos
        $articulo = $this->articuloModel->find($id);
        if (!$articulo) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Archivo no encontrado');
        }

        // Validar permisos adicionales si es necesario (opcional)
        if ($articulo['usuario_id'] != $userId) {
            return redirect()->back()->with('error', 'No tiene permisos para acceder a este archivo.');
        }

        $rutaArchivo = WRITEPATH . 'uploads/articulos/' . $articulo['ruta_archivo'];
        if (file_exists($rutaArchivo)) {
            return $this->response->download($rutaArchivo, null);
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Archivo no encontrado');
        }
    }

    // Procesar subida del artículo
    public function subirArticulo($congreso_id)
    {
        $userId = session()->get('wlp_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Debe iniciar sesión.');
        }

        // Reglas de validación
        $validationRules = [
            'titulo' => 'required|max_length[255]',
            'resumen' => 'required',
            'palabras_clave' => 'required',
            'autores' => 'required',
            'area_tematica' => 'required|integer',
            'idioma' => 'required|in_list[es,en,pt]',
            'archivo' => 'uploaded[archivo]|max_size[archivo,10240]|ext_in[archivo,pdf,zip,tar]',
            'archivo_fuente' => 'permit_empty|uploaded[archivo_fuente]|max_size[archivo_fuente,10240]|ext_in[archivo_fuente,zip,tar]',
        ];

        // Validar formulario
        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Procesar archivos
        $archivo = $this->request->getFile('archivo');
        $nombreArchivo = $archivo->getRandomName();
        $archivo->move(WRITEPATH . 'uploads/articulos/', $nombreArchivo);

        $rutaArchivoFuente = null;
        if ($this->request->getFile('archivo_fuente')) {
            $archivoFuente = $this->request->getFile('archivo_fuente');
            if ($archivoFuente->isValid()) {
                $nombreFuente = $archivoFuente->getRandomName();
                $archivoFuente->move(WRITEPATH . 'uploads/articulos/fuentes/', $nombreFuente);
                $rutaArchivoFuente = 'uploads/articulos/fuentes/' . $nombreFuente;
            }
        }

        // Insertar datos
        $data = [
            'congreso_id' => $congreso_id,
            'participante_id' => session()->get('wlp_id'),
            'categoria_id' => $this->request->getPost('area_tematica'),
            'titulo' => $this->request->getPost('titulo'),
            'resumen' => $this->request->getPost('resumen'),
            'ruta_archivo' => 'uploads/articulos/' . $nombreArchivo,
            'ruta_archivo_fuente' => $rutaArchivoFuente,
            'idioma' => $this->request->getPost('idioma'),
            'comentarios' => $this->request->getPost('comentarios'),
            'estado' => 'enviado',
            'fecha_envio' => date('Y-m-d H:i:s'),
        ];
        if ($this->articuloModel->insert($data)) {
            return redirect()->to('/mis-congresos')->with('success', 'Artículo subido correctamente.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Hubo un error al subir el artículo.');
        }
    }
}
