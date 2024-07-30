<?php

namespace App\Livewire;

use Livewire\Rule;
use App\Models\Menu;
use App\Models\Order;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MenusTable extends Component
{
    use WithPagination;
    use WithFileUploads;
    
    public $perPage = 5;
    public $search = '';

    public $menu;
    public $usedmenus =[];
    public $old_menu;
    public $price;
    public $picture;
    public $oldPicture;
    public $stock;    
    public $category_id = 1;

    public $menu_id = 0;

    public function rset(){
        $this->reset(['menu', 'price', 'stock', 'category_id', 'picture', 'menu_id', 'oldPicture']);
        $this->resetValidation();
    }

    public function createNewMenu(){
        $validated = $this->validate([
            'menu' => 'required|unique:menus|max:50',
            'price' => 'required',
            'stock' => 'required',
            'category_id' => 'required',
            'picture' => 'required|image'
        ]);

        if($this->picture){
            $validated['picture'] = $this->picture->store('menupics');
        }

        Menu::create($validated);

        $this->rset();

        $this->dispatch(
            'sweetalert',
            icon: 'success',
            title: 'Menu Berhasil Ditambahkan',
            position: 'top'
        );
    }

    public function getMenu($menuId){
        $this->resetValidation();
        $menu = Menu::find($menuId);
        $this->menu_id = $menuId;
        $this->menu = $menu->menu;
        $this->old_menu = $menu->menu;
        $this->price = $menu->price;
        // picture dibuat kosong agar preview image yang di offcanvas insert user dan update user tidak error, karena $picture harusnya berisi file gambar, bukan path gambar yang sudah disimpan di database 
        $this->picture = "";
        $this->oldPicture = $menu->picture;
        $this->stock = $menu->stock;
        $this->category_id = $menu->category_id;
    }

    public function deleteMenu(){
        Storage::delete($this->oldPicture);

        Menu::find($this->menu_id)->delete();

        $this->rset();

        $this->dispatch(
            'sweetalert',
            icon: 'error',
            title: 'Menu Berhasil Dihapus',
            position: 'top'
        );

        $this->dispatch(
            'closeoffcanvas',
            offcanvas: 'deleteMenu'
        );
    }

    public function updateMenu(){
        if($this->menu == $this->old_menu){
            $validated = $this->validate([
                'menu' => 'required',
                'price' => 'required',
                'stock' => 'required',
                'category_id' => 'required'
            ]);
        }else {
            $validated = $this->validate([
                'menu' => 'required|unique:menus|max:50',
                'price' => 'required',
                'stock' => 'required',
                'category_id' => 'required'
            ]);
        }

        $this->old_menu = $this->menu;
        
        if ($this->picture != "") {
            $validated['picture'] = $this->picture->store('menupics');
            Storage::delete($this->oldPicture);
            $this->oldPicture = $validated['picture'];
            $this->picture = '';
        }

        Menu::find($this->menu_id)->update($validated);

        $this->dispatch(
            'sweetalert',
            icon: 'warning',
            title: 'Menu Berhasil Diubah',
            position: 'top'
        );
    }
    
    public function render()
    {   
        $useds = DB::select('SELECT DISTINCT(menu_id) FROM orders');

        foreach ($useds as $used) {
            $this->usedmenus[] = $used->menu_id;
        }

        return view('livewire.menus-table', [
            'menus' => Menu::with('category')->where('menu', 'like', "%{$this->search}%")->orWhereRelation('category','category','like',"%{$this->search}%")->paginate($this->perPage),
            'categories' => Category::all()
        ]);
    }
}
