<?php

namespace Tests\Feature;

use App\Models\Distributor;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DistributorFeatureTest extends TestCase
{
    use DatabaseTransactions;

    public function test_distributor_crud_and_map_pages_work(): void
    {
        $response = $this->post(route('distributor.store'), [
            'nama_distributor' => 'Distributor Test',
            'alamat' => 'Jl. Test No. 1',
            'kota' => 'Jakarta',
            'telepon' => '021123456',
            'email' => 'test@distributor.id',
            'latitude' => -6.2,
            'longitude' => 106.8,
        ]);
        $distributor = Distributor::query()->where('nama_distributor', 'Distributor Test')->firstOrFail();

        $response->assertRedirect(route('distributor.index'));
        $this->get(route('distributor.index'))->assertOk()->assertSee('Distributor Test');
        $this->get(route('distributor.show', $distributor))->assertOk()->assertSee('Jl. Test No. 1');
        $this->get(route('distributor.map'))->assertOk()->assertSee('Peta Distributor');
        $this->put(route('distributor.update', $distributor), [
            'nama_distributor' => 'Distributor Test Updated',
            'latitude' => -7,
            'longitude' => 110,
        ])->assertRedirect(route('distributor.index'));
        $this->assertDatabaseHas('distributor', ['id' => $distributor->id, 'nama_distributor' => 'Distributor Test Updated']);
        $this->delete(route('distributor.destroy', $distributor))->assertRedirect(route('distributor.index'));
    }
}
