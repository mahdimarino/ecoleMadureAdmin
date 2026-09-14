<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\JsonResponse;

class TeacherController extends Controller
{
    private function getTeacherPhoto($photo)
    {
        $default = asset('global_assets/images/user.png');

        if (!$photo) {
            return $default;
        }

        // Remove duplicated local storage URLs
        $photo = str_replace(
            [
                'http://127.0.0.1:8000/storage/',
                'http://localhost/storage/',
            ],
            '',
            $photo
        );

        // If it is still a complete external URL, return it directly
        if (filter_var($photo, FILTER_VALIDATE_URL)) {
            return $photo;
        }

        // Stored relative path
        return asset('storage/' . ltrim($photo, '/'));
    }

    public function index(): JsonResponse
    {
        $teachers = User::where('user_type', 'teacher')
            ->where('is_approved', 1)
            ->get();

        $data = $teachers->map(function ($teacher) {

            // Get subjects taught by this teacher
            $subjects = \App\Models\Subject::where('teacher_id', $teacher->id)
                ->get();

            // Get classes connected to those subjects
            $classes = $subjects
                ->map(function ($subject) {
                    return $subject->myClass;
                })
                ->filter()
                ->unique('id')
                ->values();

            return [
                'id' => $teacher->id,

                'name' => $teacher->name,

                'photo' => $this->getTeacherPhoto($teacher->photo),

                'subject' => $subjects
                    ->pluck('name')
                    ->filter()
                    ->implode(' / '),

                'subjects' => $subjects
                    ->map(function ($subject) {
                        return [
                            'id' => $subject->id,
                            'name' => $subject->name,
                        ];
                    })
                    ->values(),

                'levels' => $classes
                    ->pluck('name')
                    ->filter()
                    ->values(),

                'programs' => [],

                'students' => null,

                'experience' => null,

                'bio' => null,

                'rating' => null,

                'reviews' => 0,
            ];
        });

        return response()->json([
            'success' => true,
            'teachers' => $data,
        ]);
    }
}

