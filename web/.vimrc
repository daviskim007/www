set nocompatible              " Vi와 호환 불가 설정, 필수
filetype off                  " 필수

" Vundle을 포함시키기 위해 runtime 경로를 설정하고 초기화
set rtp+=~/.vim/bundle/Vundle.vim
call vundle#begin()
" 기존 경로 대신 Vundle이 플러그인을 설치할 경로를 입력하십시오.
"call vundle#begin('~/some/path/here')

" Vundle이 스스로를 관리하도록 설정, 필수
Plugin 'VundleVim/Vundle.vim'

Plugin 'pangloss/vim-javascript'

" 당신의 모든 플러그인은 다음 명령어 이전에 추가되어야 합니다
call vundle#end()            " 필수
filetype plugin indent on    " 필수
" 플러그인의 들여쓰기 변화를 무시하려면, 대신 이 명령어를 사용하십시오:
"filetype plugin on
"
" 간단한 도움말
" :PluginList       - 설정된 플러그인의 리스트
" :PluginInstall    - 플러그인 설치; 업데이트를 하려면 `!`를 덧붙이거나 :PluginUpdate 명령을 사용하십시오
" :PluginSearch foo - foo에 대해 검색; `!`를 덧붙여 로컬 캐시를 새로고침하십시오
" :PluginClean      - 사용하지 않는 플러그인의 삭제를 확인; `!`를 붙여 자동 삭제를 승인하십시오
"
" 더 자세한 내용은 :h vundle 문서나 wiki의 FAQ를 확인하십시오
" 다음 줄부터 플러그인이 아닌 내용을 넣으십시오

