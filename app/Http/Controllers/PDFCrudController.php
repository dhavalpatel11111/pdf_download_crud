<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Models\PDF_crud;
use PDF;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;



class PDFCrudController extends Controller
{
    public function index()
    {
        return view("user");
    }

    public function add_user(Request $request)
    {


        $response['status'] = 1;
        $post_data = $request->all();

        $post = PDF_crud::find($post_data['hid']);

        if ($post_data['hid'] != '') {


            if (isset($post_data['img'])) {
                $filename = time() . '.' . $request->img->getClientOriginalExtension();
                $request->img->move(public_path('img'), $filename);
                $withimg = [
                    'fname' => $post_data['fname'],
                    'lname' => $post_data['lname'],
                    'email' => $post_data['email'],
                    'password' => $post_data['password'],
                    'c_password' => $post_data['c_password'],
                    'gender' => $post_data['gender'],
                    'status' => $post_data['status'],
                    'img' => $filename
                ];
            } else {
                $filename = $post['img'];
                $withimg = [
                    'fname' => $post_data['fname'],
                    'lname' => $post_data['lname'],
                    'email' => $post_data['email'],
                    'password' => $post_data['password'],
                    'c_password' => $post_data['c_password'],
                    'gender' => $post_data['gender'],
                    'status' => $post_data['status'],
                    'img' => $filename
                ];
            }


            $post->update($withimg);

            $response['status'] = 0;
            if ($post) {
                $response['status'] = 0;
                if ($response['status'] == 0) {
                    $response['mesege'] = "Data Updated ";
                } else {
                    $response['mesege'] = "Data not Updated";
                }
            } else {
            }

            return json_encode($response);
        } else {


            $filename = time() . '.' . $request->img->getClientOriginalExtension();
            $request->img->move(public_path('img'), $filename);


            if (PDF_crud::create([
                'fname' => $post_data['fname'],
                'lname' => $post_data['lname'],
                'email' => $post_data['email'],
                'password' => $post_data['password'],
                'c_password' => $post_data['c_password'],
                'gender' => $post_data['gender'],
                'status' => $post_data['status'],
                'img' => $filename
            ])) {
                $response['status'] = 0;
                if ($response['status'] == 0) {
                    $response['mesege'] = "User Created";
                } else {
                    $response['mesege'] = "Data not inserted";
                }
            } else {
            }
            return json_encode($response);
        }
    }


    public function user_list()
    {

        $alldata = PDF_crud::all();

        $no = 0;
        $data = [];
        foreach ($alldata as $value) {
            $temp['id'] = ++$no;
            $temp['fname'] = $value->fname;
            $temp['lname'] = $value->lname;
            $temp['email'] = $value->email;
            $temp['password'] = $value->password;
            $temp['c_password'] = $value->c_password;
            $temp['gender'] = $value->gender;
            $temp['img'] = "<img src='" . asset('img/' . $value['img']) . "' class='rounded shadow ' alt='here your img' height='100px' width='auto'>";
            $temp['status'] = ($value->status == 1) ? "Active" : "IN-Active";
            $temp['action'] = "<div class='container'><button class='btn btn-outline-danger m-1 shadow ' id='del' data-id='" . $value['id'] . "'>Delete</button><button class='btn btn-outline-success m-1 shadow ' id='edit' data-id='" . $value['id'] . "'>Edit</button><a href='/make_pdf/" . $value['id'] . "' class='btn btn-outline-success m-1 shadow ' id='download_pdf' data-id='" . $value['id'] . "'>Download PDF For This User</a><a href='/user_to_excel/" . $value['id'] . "' class='btn btn-outline-success m-1 shadow ' >Download Excel For This User</a></div>";

            array_push($data, $temp);
        }
        return response()->json(['data' => $data]);
    }

    public function delete_user(Request $request)
    {
        $post =   $request->post();

        $data = PDF_crud::find($post['id']);
        $data->delete();
        $responce['status'] = 0;
        if ($data) {
            $responce['status'] = 1;
            if ($responce['status'] = 1) {
                $responce['mesege'] = "User Deleted ";
            } else {
                $responce['mesege'] = "Data not Deleted";
            }
        } else {
        }
        return $responce;
    }

    public function edit_user(Request $request)
    {
        $post =   $request->post();
        $responce['status'] = 0;
        if ($post['id'] > 0) {
            $data = PDF_crud::find($post['id']);
            if (!empty($data)) {
                $responce['data'] = $data;
            } else {
                $responce['messege'] = "data not found";
                $responce['status'] = 1;
            }
        } else {
            $responce['messege'] = "somthing gone wrong";
        }
        return $responce;
    }

    public function genratePdf($id)
    {
        $users = PDF_crud::find($id)->toArray();
        $data = [
            'title' => "Welcome To Fun World",
            'date' => date('m/d/y'),
            'users' => $users
        ];

        $pdf = PDF::loadView('pdf.user_pdf', $data);
        return $pdf->download($id . '_user.pdf');
    }


    public function user_to_excel($id)
    {
        $user = PDF_crud::find($id)->toArray();
        return Excel::download(new UsersExport($user), 'users.xlsx');
    }
}
