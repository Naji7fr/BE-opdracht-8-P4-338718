<?php

declare(strict_types=1);

class VoertuigController extends Controller
{
    private Voertuig $voertuigModel;

    public function __construct()
    {
        $this->voertuigModel = new Voertuig();
    }

    public function index(): void
    {
        $currentPage = Pagination::getCurrentPage();
        $totaal = $this->voertuigModel->countAlle();
        $pagination = Pagination::buildMeta($totaal, $currentPage);
        $voertuigen = $this->voertuigModel->getAlle(
            Pagination::PER_PAGE,
            Pagination::getOffset($pagination['currentPage'])
        );

        $redirectMelding = $_SESSION['redirect_melding'] ?? null;
        $redirectMeldingType = $_SESSION['redirect_melding_type'] ?? null;
        unset($_SESSION['redirect_melding'], $_SESSION['redirect_melding_type']);

        $this->view('voertuig/index', [
            'title' => 'Alle voertuigen',
            'voertuigen' => $voertuigen,
            'totaal' => $totaal,
            'pagination' => $pagination,
            'redirectMelding' => $redirectMelding,
            'redirectMeldingType' => $redirectMeldingType,
        ]);
    }

    public function verwijder(): void
    {
        $voertuigId = filter_input(INPUT_POST, 'voertuig_id', FILTER_VALIDATE_INT);
        $pagina = filter_input(INPUT_GET, 'pagina', FILTER_VALIDATE_INT) ?: 1;

        if (!$voertuigId) {
            $_SESSION['redirect_melding'] = 'Ongeldig voertuig geselecteerd.';
            $_SESSION['redirect_melding_type'] = 'error';
            $this->redirect('/voertuigen?pagina=' . $pagina . '&melding=1');
        }

        $voertuig = $this->voertuigModel->getById((int) $voertuigId);

        if ($voertuig === null) {
            $_SESSION['redirect_melding'] = 'Voertuig niet gevonden.';
            $_SESSION['redirect_melding_type'] = 'error';
            $this->redirect('/voertuigen?pagina=' . $pagina . '&melding=1');
        }

        $isToegewezen = $this->voertuigModel->isToegewezen((int) $voertuigId);
        $isActief = (int) ($voertuig['IsActief'] ?? 0) === 1;

        if (!$isActief && !$isToegewezen) {
            $_SESSION['redirect_melding'] = 'Het door u geselecteerde voertuig staat op non actief en kan niet worden verwijderd';
            $_SESSION['redirect_melding_type'] = 'error';
            $this->redirect('/voertuigen?pagina=' . $pagina . '&melding=1');
        }

        $resultaat = $this->voertuigModel->verwijderVoertuig((int) $voertuigId);

        if ($resultaat === 'SUCCES') {
            $_SESSION['redirect_melding'] = 'Het door u geselecteerde voertuig is verwijderd';
            $_SESSION['redirect_melding_type'] = 'success';
        } else {
            $_SESSION['redirect_melding'] = match ($resultaat) {
                'NON_ACTIEF' => 'Het door u geselecteerde voertuig staat op non actief en kan niet worden verwijderd',
                default => 'Er is een fout opgetreden bij het verwijderen.',
            };
            $_SESSION['redirect_melding_type'] = 'error';
        }

        $this->redirect('/voertuigen?pagina=' . $pagina . '&melding=1');
    }
}
