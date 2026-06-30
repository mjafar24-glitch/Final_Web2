<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('member.index', [
            'title' => 'Members',
            'members' => Member::latest()->get(),
        ]);
    }

    public function create()
    {
        return view('member.create', [
            'title' => 'Create Member',
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'member_code' => 'required|unique:members,member_code',
            'name' => 'required',
            'type' => 'required|in:Student,Teacher',
            'contact' => 'nullable',
            'is_active' => 'required|boolean',
        ]);

        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            Member::create($validate);
            \Illuminate\Support\Facades\DB::commit();
            return to_route('member.index')->withSuccess('Data berhasil ditambahkan');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return to_route('member.create')->withError('Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    public function show(Member $member)
    {
        return view('member.show', [
            'title' => 'Detail Member',
            'member' => $member,
        ]);
    }

    public function edit(Member $member)
    {
        return view('member.edit', [
            'title' => 'Edit Member',
            'member' => $member,
        ]);
    }

    public function update(Request $request, Member $member)
    {
        $validate = $request->validate([
            'member_code' => 'required|unique:members,member_code,' . $member->id,
            'name' => 'required',
            'type' => 'required|in:Student,Teacher',
            'contact' => 'nullable',
            'is_active' => 'required|boolean',
        ]);

        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            $member->update($validate);
            \Illuminate\Support\Facades\DB::commit();
            return to_route('member.index')->withSuccess('Data berhasil diubah');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return to_route('member.edit', $member)->withError('Gagal mengubah data: ' . $e->getMessage());
        }
    }

    public function destroy(Member $member)
    {
        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            $member->delete();
            \Illuminate\Support\Facades\DB::commit();
            return to_route('member.index')->withSuccess('Data berhasil dihapus');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return to_route('member.index')->withError('Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
