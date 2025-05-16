<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // ==== ADMIN CRUD ====

    public function index()
    {
        // Afficher tous les utilisateurs
        $users = User::all();
        return view('users.index', compact('users'));
    }

            public function create()
        {
            return view('users.create');
        }

        public function store(Request $request)
        {
            $request->validate([
                'matricule' => 'required|string|max:255', // add this
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
                'role' => 'required|in:admin,formateur',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $imagePath = null;

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('users', 'public');
            }

            User::create([
                'matricule' => $request->matricule,  // add this line
                'name' => $request->name,
                'prename'   => $request->prename, 
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->role,
                'image' => $imagePath,
            ]);

            return redirect()->route('users.index')->with('success', 'Utilisateur ajouté avec succès.');
        }

        // Afficher un utilisateur (admin ou formateur)
    public function show($id)
    {
        $user = Auth::user();
        $showUser = User::findOrFail($id);

        if ($user->role === 'admin') {
            return view('users.show', ['user' => $showUser]);
        } elseif ($user->role === 'formateur' && $showUser->role === 'formateur') {
            return view('formateurs.show', ['user' => $showUser]);
        }

        abort(403, 'Accès refusé.');
    }

        public function edit($id)
        {
            if (!Auth::user() || Auth::user()->role !== 'admin') {
                return redirect()->route('login')->with('error', 'Accès refusé.');
            }

            $user = User::findOrFail($id);
            return view('users.edit', compact('user'));
        }

        public function update(Request $request, $id)
        {
            if (!Auth::user() || Auth::user()->role !== 'admin') {
                return redirect()->route('login')->with('error', 'Accès refusé.');
            }

            $user = User::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
                'prename'   => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'role' => 'required|in:admin,formateur',
                'password' => 'nullable|string|min:6|confirmed',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;

            if ($request->filled('password')) {
                $user->password = bcrypt($request->password);
            }

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('users', 'public'); // saved as 'users/filename.jpg'
                $user->image = $imagePath;
            }

            $user->save();

            return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès.');
        }

        public function destroy($id)
        {
            if (!Auth::user() || Auth::user()->role !== 'admin') {
                return redirect()->route('login')->with('error', 'Accès refusé.');
            }

            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès.');
        }
        
            // ==== PROFIL ====

        public function profile()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return view('users.profile', compact('user'));
        } elseif ($user->role === 'formateur') {
            return view('formateurs.profile', compact('user'));
        }

        abort(403, 'Accès refusé.');
    }

        // Editer le profil (admin ou formateur)
    public function editProfile()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return view('users.editProfile', compact('user'));
        } elseif ($user->role === 'formateur') {
            return view('formateurs.edit', compact('user'));
        }

        abort(403, 'Accès refusé.');
    }

        // Mettre à jour le profil (admin ou formateur)
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('image')) {
            $user->image = $request->file('image')->store('users', 'public');
        }

        $user->save();

        if ($user->role === 'admin') {
            return redirect()->route('users.profile')->with('success', 'Profil mis à jour.');
        } elseif ($user->role === 'formateur') {
            return redirect()->route('formateurs.profile')->with('success', 'Profil mis à jour.');
        }
    }

        public function changePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        $user->password = bcrypt($request->new_password);
        $user->save();

        if ($user->role === 'admin') {
            return redirect()->route('users.profile')->with('success', 'Mot de passe modifié avec succès.');
        } elseif ($user->role === 'formateur') {
            return redirect()->route('formateurs.profile')->with('success', 'Mot de passe modifié avec succès.');
        }
    }

        public function updatePassword(Request $request)
        {
            $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

            $user = Auth::user();

            // Logique différente selon le rôle si besoin
            if (!in_array($user->role, ['admin', 'formateur'])) {
                abort(403, "Accès refusé.");
            }

            $user->password = bcrypt($request->password);
            $user->save();

            // Redirection différente selon le rôle
            if ($user->role === 'admin') {
                return redirect()->route('users.dashboard')->with('success', 'Mot de passe modifié avec succès.');
            } elseif ($user->role === 'formateur') {
                return redirect()->route('formateurs.profile')->with('success', 'Mot de passe modifié avec succès.');
            }
        }


            // ==== DASHBOARDS ====


         // Dashboard for both admin and formateur (role-based inside)
        
            public function dashboard()
            {
                $user = Auth::user();

                if ($user->role === 'admin') {
                    $adminCount = User::where('role', 'admin')->count();
                    $formateurCount = User::where('role', 'formateur')->count();
                    return view('users.dashboard', compact('adminCount', 'formateurCount'));
                }

                if ($user->role === 'formateur') {
                    return view('formateurs.dashboard');
                }

                // Optionnel : redirection par défaut
                return redirect('/')->with('error', 'Rôle non autorisé.');
            }


        public function showLoginForm()
        {
            return view('auth.login');
        }
        public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->route('users.dashboard');
            } elseif (Auth::user()->role === 'formateur') {
                return redirect()->route('formateurs.dashboard');
            }

            // Optional: default redirect for other roles
            return redirect('/home');
        }
            return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect.',
        ])->onlyInput('email');
    }

        public function logout(Request $request)
        {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login'); // or wherever you want to send the user after logout
        }
    
}
