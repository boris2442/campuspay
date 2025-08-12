<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PDF;
use Illuminate\Support\Facades\Hash;

use App\Models\Filiere;

use App\Models\Niveau;
use App\Models\Specialite;
use App\Mail\StudentCredentialsMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class UserController extends Controller
{

    public function index(Request $request)
    {
        // $query = User::query();
        $query = User::with(['filiere', 'specialite', 'niveau', 'paiements'])
            ->where('role', 'user');  // Filtre rôle 'user';
        $filtre = null; // Variable pour stocker le filtre appliqué
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
            $filtre = 'nom';
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->input('email') . '%');
            $filtre = 'email';
        }

        if ($request->filled('sexe')) {
            $query->where('sexe', $request->input('sexe'));
            $filtre = 'sexe';
        }

        if ($request->filled('annee_naissance')) {
            $query->whereYear('date_naissance', $request->input('annee_naissance'));
            $filtre = 'annee_naissance';
        }
        $students = $query->paginate(10);
        // $students=$query::with('filiere')->paginate(10);
        // $totalEtudiants = User::count();
        $totalEtudiants = User::where('role', 'user')->count();

        return view('pages.users.list-user', compact('students', 'totalEtudiants', 'filtre'));
    }

    public function create()
    {
        $filieres = Filiere::all();
        $specialites = Specialite::all();
        $niveaux = Niveau::all();
        return view('pages.users.add-user', compact('filieres', 'specialites', 'niveaux'));
    }
    private function generatePassword($length = 8)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[random_int(0, strlen($chars) - 1)];
        }
        return $password;
    }

    /**
     * @param \App\Http\Requests\UserRequest $request
     */
    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $password = $this->generatePassword(8);
        $data['password'] = Hash::make($password);
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/students'), $filename);
            $data['photo'] = $filename;
        } else {
            $data['photo'] = null;
        }



        $user = User::create($data);
        Mail::to($user->email)->send(new StudentCredentialsMail($user, $password));
        return redirect()->route('students.index')->with('success', 'Student added successfully!');
    }

    public function edit($id)
    {
        $student = User::findOrFail($id);
        $filieres = Filiere::all();
        $specialites = Specialite::all();
        $niveaux = Niveau::all();
        return view('pages.users.update-user', compact('student', 'filieres', 'specialites', 'niveaux'));
    }
    /**
     * @param \App\Http\Requests\UserRequest $request
     */
    public function update(UserRequest $request, $id)
    {
        $student = User::findOrFail($id);
        $data = $request->validated();


        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/students'), $filename);
            $data['photo'] =  $filename;
        } else {
            $data['photo'] = $student->photo;
        }


        $student->update($data);
        return redirect()->route('students.index')->with('success', 'Student updated successfully!');
    }
    public function delete($id)
    {
        $student = User::findOrFail($id);
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student delete with successfull');
    }

    public function exportPdfUser()
    {
        $date = Carbon::now()->format('d-m-Y');
        // $students = User::all();
        $students = User::where('role', 'user')->get();
        $pdf = PDF::loadView('pages.users.pdf', compact('students'))->setPaper('a3', 'landscape');;
        return $pdf->download('liste_des_etudiants_au_' . $date . '.pdf');
    }
}
