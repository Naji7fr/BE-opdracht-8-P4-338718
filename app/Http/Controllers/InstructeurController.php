<?php

namespace App\Http\Controllers;

use App\Repositories\InstructeurRepository;
use App\Repositories\VoertuigRepository;
use Illuminate\Http\Request;

class InstructeurController extends Controller
{
    public function __construct(
        private InstructeurRepository $instructeurRepository,
        private VoertuigRepository $voertuigRepository
    ) {}

    public function index(Request $request)
    {
        $instructeurs = $this->instructeurRepository->getActiefPaginated(
            (int) $request->get('page', 1)
        );

        return view('instructeur.index', [
            'instructeurs' => $instructeurs,
            'totaal' => $this->instructeurRepository->countActief(),
        ]);
    }

    public function voertuigen(Request $request)
    {
        $instructeurId = (int) $request->query('id');

        if ($instructeurId <= 0) {
            return redirect()->route('instructeurs.index')
                ->with('melding', 'Ongeldige instructeur geselecteerd.')
                ->with('melding_type', 'error');
        }

        $instructeur = $this->instructeurRepository->findActief($instructeurId);

        if ($instructeur === null) {
            return redirect()->route('instructeurs.index')
                ->with('melding', 'Instructeur niet gevonden.')
                ->with('melding_type', 'error');
        }

        $voertuigen = $this->voertuigRepository->getVoorInstructeurPaginated(
            $instructeurId,
            (int) $request->get('page', 1)
        );

        $instructeurNaam = trim(implode(' ', array_filter([
            $instructeur->Voornaam,
            $instructeur->Tussenvoegsel ?? '',
            $instructeur->Achternaam,
        ])));

        return view('instructeur.voertuigen', [
            'instructeur' => $instructeur,
            'instructeurNaam' => $instructeurNaam,
            'voertuigen' => $voertuigen,
        ]);
    }

    public function verwijderVoertuig(Request $request)
    {
        $instructeurId = (int) $request->input('instructeur_id');
        $voertuigId = (int) $request->input('voertuig_id');

        if ($instructeurId <= 0 || $voertuigId <= 0) {
            return redirect()->route('instructeurs.index')
                ->with('melding', 'Ongeldige gegevens ontvangen.')
                ->with('melding_type', 'error');
        }

        $instructeur = $this->instructeurRepository->findActief($instructeurId);

        if ($instructeur === null) {
            return redirect()->route('instructeurs.index')
                ->with('melding', 'Instructeur niet gevonden.')
                ->with('melding_type', 'error');
        }

        $resultaat = $this->voertuigRepository->verwijderVanInstructeur($voertuigId, $instructeurId);

        if ($resultaat === 'SUCCES') {
            return redirect()->route('instructeurs.voertuigen', [
                'id' => $instructeurId,
                'melding' => 1,
            ])->with('redirect_melding', 'Het door u geselecteerde voertuig is verwijderd')
                ->with('redirect_melding_type', 'success');
        }

        $melding = match ($resultaat) {
            'NON_ACTIEF' => 'Het door u geselecteerde voertuig staat op non actief en kan niet worden verwijderd',
            'GEEN_KOPPELING' => 'Dit voertuig is niet gekoppeld aan de geselecteerde instructeur.',
            default => 'Er is een fout opgetreden bij het verwijderen.',
        };

        return redirect()->route('instructeurs.voertuigen', [
            'id' => $instructeurId,
            'melding' => 1,
        ])->with('redirect_melding', $melding)
            ->with('redirect_melding_type', 'error');
    }

    public function toevoegenVoertuig(Request $request)
    {
        $instructeur = $this->resolveInstructeur($request);

        if ($instructeur === null) {
            return redirect()->route('instructeurs.index')
                ->with('melding', 'Instructeur niet gevonden.')
                ->with('melding_type', 'error');
        }

        $voertuigen = $this->voertuigRepository->getBeschikbaarPaginated(
            (int) $request->get('page', 1)
        );

        return view('instructeur.toevoegen', [
            'instructeur' => $instructeur,
            'instructeurNaam' => $this->formatInstructeurNaam($instructeur),
            'voertuigen' => $voertuigen,
        ]);
    }

    public function toevoegenVoertuigOpslaan(Request $request)
    {
        $instructeurId = (int) $request->input('instructeur_id');
        $voertuigId = (int) $request->input('voertuig_id');

        $instructeur = $this->instructeurRepository->findActief($instructeurId);

        if ($instructeur === null || $voertuigId <= 0) {
            return redirect()->route('instructeurs.index')
                ->with('melding', 'Ongeldige gegevens ontvangen.')
                ->with('melding_type', 'error');
        }

        if ($this->voertuigRepository->voertuigToewijzen($voertuigId, $instructeurId)) {
            return redirect()->route('instructeurs.voertuigen', ['id' => $instructeurId])
                ->with('melding', 'Het voertuig is toegevoegd aan de instructeur.')
                ->with('melding_type', 'info');
        }

        return redirect()->route('instructeurs.voertuigen.toevoegen', ['id' => $instructeurId])
            ->with('melding', 'Dit voertuig kon niet worden toegewezen.')
            ->with('melding_type', 'error');
    }

    public function wijzigVoertuig(Request $request)
    {
        $instructeur = $this->resolveInstructeur($request);

        if ($instructeur === null) {
            return redirect()->route('instructeurs.index')
                ->with('melding', 'Instructeur niet gevonden.')
                ->with('melding_type', 'error');
        }

        $voertuigId = (int) $request->query('voertuig_id');

        if ($voertuigId <= 0) {
            return redirect()->route('instructeurs.voertuigen', ['id' => $instructeur->Id])
                ->with('melding', 'Ongeldig voertuig geselecteerd.')
                ->with('melding_type', 'error');
        }

        $voertuig = $this->voertuigRepository->findMetTypeVoorInstructeur($voertuigId, (int) $instructeur->Id);

        if ($voertuig === null) {
            return redirect()->route('instructeurs.voertuigen', ['id' => $instructeur->Id])
                ->with('melding', 'Voertuig niet gevonden bij deze instructeur.')
                ->with('melding_type', 'error');
        }

        return view('instructeur.wijzig', [
            'instructeur' => $instructeur,
            'instructeurNaam' => $this->formatInstructeurNaam($instructeur),
            'voertuig' => $voertuig,
        ]);
    }

    public function wijzigVoertuigOpslaan(Request $request)
    {
        $instructeurId = (int) $request->input('instructeur_id');
        $voertuigId = (int) $request->input('voertuig_id');

        $instructeur = $this->instructeurRepository->findActief($instructeurId);

        if ($instructeur === null || $voertuigId <= 0) {
            return redirect()->route('instructeurs.index')
                ->with('melding', 'Ongeldige gegevens ontvangen.')
                ->with('melding_type', 'error');
        }

        $voertuig = $this->voertuigRepository->findMetTypeVoorInstructeur($voertuigId, $instructeurId);

        if ($voertuig === null) {
            return redirect()->route('instructeurs.voertuigen', ['id' => $instructeurId])
                ->with('melding', 'Voertuig niet gevonden bij deze instructeur.')
                ->with('melding_type', 'error');
        }

        $request->validate([
            'kenteken' => 'required|string|max:15',
            'type' => 'required|string|max:50',
            'brandstof' => 'required|string|max:20',
        ]);

        $this->voertuigRepository->updateVoertuig($voertuigId, [
            'kenteken' => $request->input('kenteken'),
            'type' => $request->input('type'),
            'brandstof' => $request->input('brandstof'),
        ]);

        return redirect()->route('instructeurs.voertuigen', ['id' => $instructeurId])
            ->with('melding', 'Het voertuig is gewijzigd.')
            ->with('melding_type', 'info');
    }

    private function resolveInstructeur(Request $request): ?object
    {
        $instructeurId = (int) $request->query('id');

        if ($instructeurId <= 0) {
            return null;
        }

        return $this->instructeurRepository->findActief($instructeurId);
    }

    private function formatInstructeurNaam(object $instructeur): string
    {
        return trim(implode(' ', array_filter([
            $instructeur->Voornaam,
            $instructeur->Tussenvoegsel ?? '',
            $instructeur->Achternaam,
        ])));
    }
}
