<?php

namespace App\Http\Controllers;

use App\Models\Organiser;
use File;
use Image;
use Illuminate\Http\Request;
use Validator;

class OrganiserCustomizeController extends MyBaseController
{
    /**
     * Show organiser setting page
     *
     * @param $organiser_id
     * @return mixed
     */
    public function showCustomize($organiser_id)
    {
        $data = [
            'organiser' => Organiser::scope()->findOrFail($organiser_id),
        ];

        return view('ManageOrganiser.Customize', $data);
    }

    /**
     * Edits organiser settings / design etc.
     *
     * @param Request $request
     * @param $organiser_id
     * @return mixed
     */
    public function postEditOrganiser(Request $request, $organiser_id)
    {
        $organiser = Organiser::scope()->find($organiser_id);

        if (!$organiser->validate($request->all())) {
            return response()->json([
                'status'   => 'error',
                'messages' => $organiser->errors(),
            ]);
        }

        $organiser->name                  = $request->get('name');
        $organiser->about                 = $request->get('about');
        $organiser->google_analytics_code = $request->get('google_analytics_code');
        $organiser->email                 = $request->get('email');
        $organiser->enable_organiser_page = $request->get('enable_organiser_page');
        $organiser->facebook              = $request->get('facebook');
        $organiser->twitter               = $request->get('twitter');

        if ($request->get('remove_current_image') == '1') {
            $organiser->logo_path = '';
        }

        if ($request->hasFile('organiser_logo')) {
            $the_file = \File::get($request->file('organiser_logo')->getRealPath());
            $file_name = str_slug($organiser->name).'-logo-'.$organiser->id.'.'.strtolower($request->file('organiser_logo')->getClientOriginalExtension());

            $relative_path_to_file = config('attendize.organiser_images_path').'/'.$file_name;
            $full_path_to_file = public_path($relative_path_to_file);

            $img = Image::make($the_file);

            $img->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $img->save($full_path_to_file);

            if (\Storage::put($file_name, $the_file)) {
                $organiser->logo_path = $relative_path_to_file;
            }
        }

        $organiser->save();

        session()->flash('message', 'Organisateur mis à jour avec succès');

        return response()->json([
            'status'      => 'success',
            'redirectUrl' => '',
        ]);
    }

    /**
     * Edits organiser profile page colors / design
     *
     * @param Request $request
     * @param $organiser_id
     * @return mixed
     */
    public function postEditOrganiserPageDesign(Request $request, $organiser_id)
    {
        $event = Organiser::scope()->findOrFail($organiser_id);

        $rules = [
            'page_bg_color'        => ['required'],
            'page_header_bg_color' => ['required'],
            'page_text_color'      => ['required'],
        ];
        $messages = [
            'page_header_bg_color.required' => 'Please enter a header background color.',
            'page_bg_color.required'        => 'Please enter a background color.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'messages' => $validator->messages()->toArray(),
            ]);
        }

        $event->page_bg_color        = $request->get('page_bg_color');
        $event->page_header_bg_color = $request->get('page_header_bg_color');
        $event->page_text_color      = $request->get('page_text_color');

        $event->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'La conception de l\'organiseur a été mise à jour',
        ]);
    }
}
