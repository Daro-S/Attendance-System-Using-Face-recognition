<?php

namespace App\Http\Controllers\Api;


use App\Models\Student;
use App\Models\StudentDetail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentController
{
    public function getStudentImages(Request $request): JsonResponse
    {
        set_time_limit(120);
        $studentId = $request->input('student_id');
        $student = Student::with('studentDetails')->where('id', $studentId)->first();
        $studentData = [
            'id' => $studentId,
            'name' => $student->name,
            'images' => null
        ];
        if (!empty($student->studentDetails)) {
            $image = [];
            foreach ($student->studentDetails as $studentDetail) {
                $image[] = $this->imageToBase64($studentDetail->image_path);
            }
            $studentData['images'] = $image;
        }

        return response()->json($studentData);
    }

    private function imageToBase64($path): string
    {
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }


}
