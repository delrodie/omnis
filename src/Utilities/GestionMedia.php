<?php


namespace App\Utilities;


use Cocur\Slugify\Slugify;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class GestionMedia
{
    private $mediaIdentite;
    private $mediaBac;
    private $mediaDernierDiplome;
    private $mediaEtudiantPhoto;

    public function __construct($mediaIdentite, $mediaBac, $mediaDernierDiplome, $mediaEtudiantPhoto)
    {
        $this->mediaIdentite = $mediaIdentite;
        $this->mediaBac = $mediaBac;
        $this->mediaDernierDiplome = $mediaDernierDiplome;
        $this->mediaEtudiantPhoto = $mediaEtudiantPhoto;
    }

    public function upload(UploadedFile $file, $media = null)
    {
        $slugify = new Slugify();

        $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $slugify->slugify($originalFileName);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        // Deplacement du fichier dans le repertoire dedié
        try {
            if ($media === 'identite') $file->move($this->mediaIdentite, $newFilename);
            elseif ($media === 'bac') $file->move($this->mediaBac, $newFilename);
            elseif ($media === 'diplome') $file->move($this->mediaDernierDiplome, $newFilename);
            elseif ($media === 'photo') $file->move($this->mediaEtudiantPhoto, $newFilename);
            else $file->move($this->mediaIdentite, $newFilename);
        }catch (FileException $e){

        }

        return $newFilename;

    }

    /**
     * Suppression de l'ancien media sur le server
     *
     * @param $ancienMedia
     * @param null $media
     * @return bool
     */
    public function removeUpload($ancienMedia, $media = null)
    {
        if ($media === 'cover') unlink($this->mediaAlbum.'/'.$ancienMedia);
        elseif ($media === 'img1920') unlink($this->media1920.'/'.$ancienMedia);
        elseif ($media === 'img480') unlink($this->media480.'/'.$ancienMedia);
        else unlink($this->media250.'/'.$ancienMedia);

        return true;
    }
}