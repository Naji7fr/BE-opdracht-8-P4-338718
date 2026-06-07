<?php

namespace App\Http\Controllers;

use App\Repositories\VoertuigRepository;
use Illuminate\Http\Request;

class VoertuigController extends Controller
{
    public function __construct(
        private VoertuigRepository $voertuigRepository
    ) {}

    public function index(Request $request)
    {
        $voertuigen = $this->voertuigRepository->getAllePaginated(
            (int) $request->get('page', 1)
        );

        return view('voertuig.index', [
            'voertuigen' => $voertuigen,
        ]);
    }

    public function verwijder(Request $request)
    {
        $voertuigId = (int) $request->input('voertuig_id');
        $page = (int) $request->get('page', 1);

        if ($voertuigId <= 0) {
            return redirect()->route('voertuigen.index', ['page' => $page, 'melding' => 1])
                ->with('redirect_melding', 'Ongeldig voertuig geselecteerd.')
                ->with('redirect_melding_type', 'error');
        }

        $voertuig = $this->voertuigRepository->findById($voertuigId);

        if ($voertuig === null) {
            return redirect()->route('voertuigen.index', ['page' => $page, 'melding' => 1])
                ->with('redirect_melding', 'Voertuig niet gevonden.')
                ->with('redirect_melding_type', 'error');
        }

        $isToegewezen = $this->voertuigRepository->isToegewezen($voertuigId);
        $isActief = (int) ($voertuig->IsActief ?? 0) === 1;

        if (! $isActief && ! $isToegewezen) {
            return redirect()->route('voertuigen.index', ['page' => $page, 'melding' => 1])
                ->with('redirect_melding', 'Het door u geselecteerde voertuig staat op non actief en kan niet worden verwijderd')
                ->with('redirect_melding_type', 'error');
        }

        $resultaat = $this->voertuigRepository->verwijderVoertuig($voertuigId);

        if ($resultaat === 'SUCCES') {
            return redirect()->route('voertuigen.index', ['page' => $page, 'melding' => 1])
                ->with('redirect_melding', 'Het door u geselecteerde voertuig is verwijderd')
                ->with('redirect_melding_type', 'success');
        }

        $melding = match ($resultaat) {
            'NON_ACTIEF' => 'Het door u geselecteerde voertuig staat op non actief en kan niet worden verwijderd',
            default => 'Er is een fout opgetreden bij het verwijderen.',
        };

        return redirect()->route('voertuigen.index', ['page' => $page, 'melding' => 1])
            ->with('redirect_melding', $melding)
            ->with('redirect_melding_type', 'error');
    }
}
