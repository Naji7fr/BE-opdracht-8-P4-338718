<?php

declare(strict_types=1);

class InstructeurController extends Controller
{
    private Instructeur $instructeurModel;
    private Voertuig $voertuigModel;

    public function __construct()
    {
        $this->instructeurModel = new Instructeur();
        $this->voertuigModel = new Voertuig();
    }

    public function index(): void
    {
        $currentPage = Pagination::getCurrentPage();
        $offset = Pagination::getOffset($currentPage);
        $totaal = $this->instructeurModel->countActief();
        $pagination = Pagination::buildMeta($totaal, $currentPage);
        $instructeurs = $this->instructeurModel->getAllActief(
            Pagination::PER_PAGE,
            Pagination::getOffset($pagination['currentPage'])
        );

        $this->view('instructeur/index', [
            'title' => 'Instructeurs in dienst',
            'instructeurs' => $instructeurs,
            'totaal' => $totaal,
            'pagination' => $pagination,
            'melding' => $_SESSION['melding'] ?? null,
            'meldingType' => $_SESSION['melding_type'] ?? null,
        ]);

        unset($_SESSION['melding'], $_SESSION['melding_type']);
    }

    public function voertuigen(): void
    {
        $instructeurId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$instructeurId) {
            $_SESSION['melding'] = 'Ongeldige instructeur geselecteerd.';
            $_SESSION['melding_type'] = 'error';
            $this->redirect('/instructeurs');
        }

        $instructeur = $this->instructeurModel->getById((int) $instructeurId);

        if ($instructeur === null) {
            $_SESSION['melding'] = 'Instructeur niet gevonden.';
            $_SESSION['melding_type'] = 'error';
            $this->redirect('/instructeurs');
        }

        $currentPage = Pagination::getCurrentPage();
        $totaal = $this->voertuigModel->countVoorInstructeur((int) $instructeurId);
        $pagination = Pagination::buildMeta($totaal, $currentPage);
        $voertuigen = $this->voertuigModel->getVoorInstructeur(
            (int) $instructeurId,
            Pagination::PER_PAGE,
            Pagination::getOffset($pagination['currentPage'])
        );

        $redirectMelding = $_SESSION['redirect_melding'] ?? null;
        $redirectMeldingType = $_SESSION['redirect_melding_type'] ?? null;
        unset($_SESSION['redirect_melding'], $_SESSION['redirect_melding_type']);

        $this->view('instructeur/voertuigen', [
            'title' => 'Door Instructeur gebruikte voertuigen',
            'instructeur' => $instructeur,
            'instructeurNaam' => $this->instructeurModel->getVolledigeNaam($instructeur),
            'voertuigen' => $voertuigen,
            'totaal' => $totaal,
            'pagination' => $pagination,
            'redirectMelding' => $redirectMelding,
            'redirectMeldingType' => $redirectMeldingType,
        ]);
    }

    public function verwijderVoertuig(): void
    {
        $instructeurId = filter_input(INPUT_POST, 'instructeur_id', FILTER_VALIDATE_INT);
        $voertuigId = filter_input(INPUT_POST, 'voertuig_id', FILTER_VALIDATE_INT);

        if (!$instructeurId || !$voertuigId) {
            $_SESSION['melding'] = 'Ongeldige gegevens ontvangen.';
            $_SESSION['melding_type'] = 'error';
            $this->redirect('/instructeurs');
        }

        $instructeur = $this->instructeurModel->getById((int) $instructeurId);

        if ($instructeur === null) {
            $_SESSION['melding'] = 'Instructeur niet gevonden.';
            $_SESSION['melding_type'] = 'error';
            $this->redirect('/instructeurs');
        }

        $resultaat = $this->voertuigModel->verwijderVanInstructeur((int) $voertuigId, (int) $instructeurId);

        if ($resultaat === 'SUCCES') {
            $_SESSION['redirect_melding'] = 'Het door u geselecteerde voertuig is verwijderd';
            $_SESSION['redirect_melding_type'] = 'success';
            $this->redirect('/instructeurs/voertuigen?id=' . $instructeurId . '&melding=1');
        }

        $_SESSION['redirect_melding'] = match ($resultaat) {
            'NON_ACTIEF' => 'Het door u geselecteerde voertuig staat op non actief en kan niet worden verwijderd',
            'GEEN_KOPPELING' => 'Dit voertuig is niet gekoppeld aan de geselecteerde instructeur.',
            default => 'Er is een fout opgetreden bij het verwijderen.',
        };
        $_SESSION['redirect_melding_type'] = 'error';
        $this->redirect('/instructeurs/voertuigen?id=' . $instructeurId . '&melding=1');
    }
}
