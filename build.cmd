setlocal
call %~dp0..\vc_setup.cmd
set BUILD=build
title Configuring SWIG
%CMAKE% -S . -B %BUILD% -DPCRE2_ROOT=%~dp0pcre2\build -DPCRE2_LIBRARY=%~dp0pcre2\build\Release\pcre2-8-static.lib -DCMAKE_C_FLAGS="/WX /DPCRE2_STATIC" -DCMAKE_CXX_FLAGS="/WX /DPCRE2_STATIC"
title Building SWIG Debug
msbuild /m %BUILD%\swig.sln -p:Configuration=Debug
title Building SWIG Release
msbuild /m %BUILD%\swig.sln -p:Configuration=Release
copy %BUILD%\Release\swig.exe .
title Done building SWIG
NuGet.exe pack swig.nuspec -OutputDirectory %PACKAGES%\nuget_packages
endlocal
